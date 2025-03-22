<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {

        $jobs = Job::with(['company', 'categories'])->orderBy('created_at', 'desc');

        if ($request->has('category') && !empty($request->category)) {
            $categoryIds = is_array($request->category) ? $request->category : [$request->category];

            $jobs->whereHas('categories', function ($query) use ($categoryIds) {
                $query->whereIn('categories.id', $categoryIds);
            });
        }

        // Apply job type filter if provided
        if ($request->has('type') && !empty($request->type)) {
            $jobs->whereIn('type', $request->type);
        }

        // Filter by company
        if ($request->has('company') && !empty($request->company)) {
            $jobs->where('company_id', (int) $request->company);
        }

        // Filter by location
        if ($request->has('location') && !empty($request->location)) {
            $jobs->where('location', $request->location);
        }

        // Paginate results
        $data['jobs'] = $jobs->paginate(5);

        // Fetch categories & companies for filters
        $data['categories'] = Category::all();
        $data['companies'] = Company::all();

        // If request is AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.job-listings', $data)->render(),
            ]);
        }

        // Return full view for non-AJAX requests
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

}
