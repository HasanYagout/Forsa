<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        // Start building the query
        $jobs = Job::query()->with('company')->orderBy('created_at', 'desc');

        // Apply category filter if provided
        if ($request->has('category') && $request->category != '') {
            // Decode the JSON array of category IDs
            $categoryIds = json_decode($request->category);

            // Filter jobs by category IDs stored in JSON
            $jobs->where(function ($query) use ($categoryIds) {
                $query->orWhereJsonContains('category_id', $categoryIds);
            });
        }

        // Apply job type filter if provided
        if ($request->has('type') && !empty($request->type)) {
            // Use whereIn for type filter
            $jobs->whereIn('type', $request->type);
        }

        // Apply location filter if provided
        if ($request->has('location') && $request->location != '') {
            $jobs->where('location', $request->location);
        }

        // Paginate the results
        $data['jobs'] = $jobs->paginate(2);

        // Fetch categories for the filter dropdown
        $data['categories'] = Category::all();

        // Check if the request is an AJAX request
        if ($request->ajax()) {
            // Return JSON response for AJAX requests
            return response()->json([
                'html' => view('partials.job-listings', $data)->render(),
            ]);
        }

        // Return the full view for non-AJAX requests
        return view('jobs.index', $data);
    }
}
