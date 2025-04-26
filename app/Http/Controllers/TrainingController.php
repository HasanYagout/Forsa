<?php

namespace App\Http\Controllers;

use App\Helpers\Location;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index(Request $request)
    {
        // Initialize query
        $trainings = Training::with(['company', 'categories'])->available()->orderBy('created_at', 'desc');

        // Handle both 'category' and 'categories' parameters for backward compatibility
        $categoryIds = [];

        // Check for multiple categories first

        if ($request->has('categories')) {
            $categoryIds = is_array($request->categories)
                ? $request->categories
                : json_decode($request->categories, true);
        }
        // Fallback to single category
        elseif ($request->has('category') && !empty($request->category)) {
            $categoryIds = is_array($request->category)
                ? $request->category
                : [$request->category];
        }

        // Filter by categories if we have valid IDs
        if (!empty($categoryIds)) {
            // Clean and validate category IDs
            $validCategoryIds = array_filter(array_map('intval', $categoryIds), function($id) {
                return $id > 0;
            });

            if (!empty($validCategoryIds)) {
                $trainings->whereHas('categories', function($query) use ($validCategoryIds) {
                    $query->whereIn('categories.id', $validCategoryIds);
                });
            }
        }

        // Filter by job type
        if ($request->has('type') && !empty($request->type)) {
            $type = is_array($request->type) ? $request->type : [$request->type];
            $trainings->whereIn('type', $type);
        }

        // Filter by job title
        if ($request->has('title') && !empty($request->title)) {
            $trainings->where('title', 'like', '%' . $request->title . '%');
        }

        // Filter by company
        if ($request->has('company') && !empty($request->company)) {
            $trainings->where('company_id', (int) $request->company);
        }
//        dd($request->all());
        // Filter by location
        if ($request->has('location') && !empty($request->location)) {
            $searchTerm = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->location));
            $trainings->where(function($query) use ($searchTerm) {
                $query->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(location, '''', ''), ' ', ''), '-', '')) LIKE ?", ['%' . $searchTerm . '%']);
            });
        }


        // Paginate results with preserved filters
        $data['trainings'] = $trainings->paginate(5)->appends($request->query());

        // Fetch filter data
        $data['categories'] = Category::whereHas('trainings', function($query) use ($request) {
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

        $data['companies'] = Company::whereHas('trainings', function($query) use ($request) {
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
        $existingLocations = Training::query()
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
        // AJAX response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('components.partials.listings', [
                    'records' => $data['trainings'],
                    'title' => 'trainings'
                ])->render(),
                'queryParams' => $request->query() // Return current query parameters
            ]);
        }

        return view('trainings.index', $data);
    }

    public function view(Request $request, $slug)
    {
        $data['training'] = Training::with('categories')->where('slug', $slug)->first();

        if (!$data['training']) {
            abort(404, 'Training not found');
        }

        // Similar trainings from the same company
        $data['similar_trainings'] = Training::with('company')
            ->where('slug', '!=', $slug)
            ->where('company_id', $data['training']->company_id)
            ->available()
            ->latest()
            ->take(3)
            ->get();

        // Fallback: random trainings if none found
        if ($data['similar_trainings']->isEmpty()) {
            $data['similar_trainings'] = Training::with('company')
                ->where('slug', '!=', $slug)
                ->available()
                ->inRandomOrder()
                ->take(3)
                ->get();
        }

        // Get the category IDs of the training
        $categoryIds = $data['training']->categories->pluck('id');

        // Similar jobs by categories
        $data['similar_jobs'] = Job::with('categories')
            ->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            })
            ->available()
            ->latest()
            ->take(3)
            ->get();

        // Fallback: random jobs if none found
        if ($data['similar_jobs']->isEmpty()) {
            $data['similar_jobs'] = Job::with('categories')
                ->available()
                ->inRandomOrder()
                ->take(3)
                ->get();
        }

        return view('trainings.view', $data);
    }
}
