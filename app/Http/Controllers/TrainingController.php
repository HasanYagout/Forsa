<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    public function index(Request $request)
    {
        // Initialize query
        $trainings = Training::with(['company', 'categories'])->orderBy('created_at', 'desc');

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
        $data['categories'] = Category::all();
        $data['companies'] = Company::all();

        // AJAX response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('components.partials.trainings-listings', $data)->render(),
                'queryParams' => $request->query()
            ]);
        }

        return view('trainings.index', $data);
    }

    public function view(Request $request, $slug)
    {
        $data['training'] = Training::where('slug', $slug)->first();

        if (!$data['training']) {
            abort(404, 'Training not found');
        }
        $data['similar_trainings']=Training::with('company')->whereNot('slug',$slug)->where('company_id', $data['training']->company_id)->latest(5)->get();
        return view('trainings.view', $data);
    }
}
