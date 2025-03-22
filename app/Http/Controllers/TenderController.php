<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Company;
use App\Models\Tender;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $tenders = Tender::with(['company'])->orderBy('created_at', 'desc');

        // Filter by company
        if ($request->has('company') && !empty($request->company)) {
            $tenders->where('company_id', (int) $request->company);
        }

        // Filter by location
        if ($request->has('location') && !empty($request->location)) {
            $tenders->where('location', $request->location);
        }

        // Paginate results
        $data['tenders'] = $tenders->paginate(5);

        // Fetch categories & companies for filters
        $data['categories'] = Category::all();
        $data['companies'] = Company::all();

        // If request is AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.tenders-listings', $data)->render(),
            ]);
        }

        // Return full view for non-AJAX requests
        return view('tenders.index', $data);

    }
}
