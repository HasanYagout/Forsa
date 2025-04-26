<?php
namespace App\Http\Controllers;

use App\Helpers\Location;
use App\Models\Bug;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\Training;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = Job::with(['company', 'categories'])
            ->available()
            ->where('deadline', '>=', now()) // 🔥 Don't show expired jobs
            ->orderBy('created_at', 'desc');

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $categoryIds = is_array($request->category) ? $request->category : [$request->category];

            $jobs->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            });
        }


        // Filter by job title
        if ($request->has('title') && !empty($request->title)) {
            $searchTerm = '%' . $request->title . '%';
            $jobs->where(function($query) use ($searchTerm) {
                $query->where('title', 'LIKE', $searchTerm)
                    ->orWhereHas('company', function($q) use ($searchTerm) {
                        $q->where('name', 'LIKE', $searchTerm);
                    });
            });
        }

        // Filter by company
        if ($request->has('company') && !empty($request->company)) {
            $jobs->where('company_id', (int) $request->company);
        }

        // 🔹 **Filter by location (Case Insensitive)**
        if ($request->has('location') && !empty($request->location)) {
            $searchTerm = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->location));

            $jobs->where(function($query) use ($searchTerm) {
                $query->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(location, '''', ''), ' ', ''), '-', '')) LIKE ?", ['%' . $searchTerm . '%']);
            });
        }
        // Paginate results
        $data['jobs'] = $jobs->paginate(5)->appends($request->query());

        // Fetch categories & companies for filters
        $data['categories'] = Category::whereHas('jobs', function($query) use ($request) {
            $query->available();
            // Apply the same filters to the category query
            if ($request->has('company') && !empty($request->company)) {
                $query->where('company_id', (int) $request->company);
            }
            if ($request->has('type') && !empty($request->type)) {
                $query->whereIn('type', (array) $request->type);
            }
            if ($request->has('location') && !empty($request->location)) {
                $searchTerm = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->location));
                $query->where(function($q) use ($searchTerm) {
                    $q->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(location, '''', ''), ' ', ''), '-', '')) LIKE ?", ['%' . $searchTerm . '%']);
                });
            }
        })->get();

        $data['companies'] = Company::whereHas('job', function($query) use ($request) {
            $query->available();

            // Apply the same filters to the company query
            if ($request->has('category') && !empty($request->category)) {
                $categoryIds = is_array($request->category) ? $request->category : [$request->category];
                $query->whereHas('categories', function($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                });
            }
            if ($request->has('type') && !empty($request->type)) {
                $query->whereIn('type', (array) $request->type);
            }
            if ($request->has('location') && !empty($request->location)) {
                $searchTerm = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->location));
                $query->where(function($q) use ($searchTerm) {
                    $q->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(location, '''', ''), ' ', ''), '-', '')) LIKE ?", ['%' . $searchTerm . '%']);
                });
            }
        })->get();

        $existingLocations = Job::query()
            ->when($request->filled('company'), function($query) use ($request) {
                $query->where('company_id', (int) $request->company);
            })
            ->when($request->filled('category'), function($query) use ($request) {
                $categoryIds = is_array($request->category) ? $request->category : [$request->category];
                $query->whereHas('categories', function($q) use ($categoryIds) {
                    $q->whereIn('categories.id', $categoryIds);
                });
            })
            ->when($request->filled('type'), function($query) use ($request) {
                $query->whereIn('type', (array) $request->type);
            })
            ->available()
        ->whereNotNull('location')
            ->where('location', '!=', '')
            ->distinct()
            ->pluck('location')
            ->flatten()       // Flatten the nested array
            ->unique()        // Remove duplicates
            ->filter()        // Remove empty values
            ->values()        // Reset array keys
            ->toArray();

        $data['locations'] = array_filter(
            Location::cities(),
            function($location) use ($existingLocations) {
                return in_array($location, $existingLocations);
            }
        );


        // Return AJAX response if needed
        if ($request->ajax()) {
            return response()->json([
                'html' => view('components.partials.listings', [
                    'records' => $data['jobs'],
                    'title' => 'jobs'
                ])->render(),
                'queryParams' => $request->query() // Return current query parameters
            ]);
        }


        return view('jobs.index', $data);
    }

    public function view(Request $request, $slug)
    {
        $data['job'] = Job::with('categories')->where('slug', $slug)->first();

        if (!$data['job']) {
            abort(404, 'Job not found');
        }

        // Get the category IDs of the job (array)
        $jobCategoryIds = $data['job']->category_id ?? [];

        // Similar jobs from the same categories
        $data['similar_jobs'] = Job::with('company')
            ->where('slug', '!=', $slug)
            ->where(function($query) use ($jobCategoryIds) {
                foreach ($jobCategoryIds as $categoryId) {
                    $query->orWhereJsonContains('category_id', $categoryId);
                }
            })
            ->latest()
            ->available()
            ->take(3)
            ->get();

        // If no similar jobs found, fallback to random jobs from the same company
        if ($data['similar_jobs']->isEmpty()) {
            $data['similar_jobs'] = Job::with('company')
                ->where('slug', '!=', $slug)
                ->where('company_id', $data['job']->company_id)
                ->available()
                ->inRandomOrder()
                ->take(3)
                ->get();
        }

        // Trainings part (no change needed)
        $categoryIds = $data['job']->categories->pluck('id');

        $data['similar_trainings'] = Training::with('categories')
            ->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->available()
            ->latest()
            ->take(3)
            ->get();

        if ($data['similar_trainings']->isEmpty()) {
            $data['similar_trainings'] = Training::with('categories')
                ->available()
                ->inRandomOrder()
                ->take(3)
                ->get();
        }

        return view('jobs.view', $data);
    }



}
