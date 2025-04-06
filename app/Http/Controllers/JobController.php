<?php
namespace App\Http\Controllers;

use App\Models\Bug;
use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = Job::with(['company', 'categories'])->orderBy('created_at', 'desc');

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $categoryIds = is_array($request->category) ? $request->category : [$request->category];

            $jobs->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            });
        }

        // Filter by job type
        if ($request->has('type') && !empty($request->type)) {
            $jobs->whereIn('type', (array) $request->type);
        }

        // Filter by job title
        if ($request->has('title') && !empty($request->title)) {
            $jobs->where('title', 'like', '%' . $request->title . '%');
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
        $data['categories'] = Category::all();
        $data['companies'] = Company::all();


        // Return AJAX response if needed
        if ($request->ajax()) {
            return response()->json([
                'html' => view('components.partials.job-listings', $data)->render(),
                'queryParams' => $request->query() // Return current query parameters
            ]);
        }

        return view('jobs.index', $data);
    }

    public function view(Request $request, $slug)
    {
        $data['job'] = Job::where('slug', $slug)->first();

        if (!$data['job']) {
            abort(404, 'Job not found');
        }
        $data['similar_jobs']=Job::with('company')->whereNot('slug',$slug)->where('company_id', $data['job']->company_id)->latest(5)->get();

        return view('jobs.view', $data);
    }

    public function bug(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'mobile' => 'required|numeric', // Corrected validation rule
                'message' => 'required|string',
            ]);

            // Create a new bug report
            Bug::create($validated);

            // Flash a success message to the session
            return back()->with('success', 'Your message has been received!');
        } catch (\Exception $e) {
            // Flash an error message to the session
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

}
