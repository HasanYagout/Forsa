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
            $searchTerm = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->location));

            $tenders->where(function($query) use ($searchTerm) {
                $query->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(location, '''', ''), ' ', ''), '-', '')) LIKE ?", ['%' . $searchTerm . '%']);
            });
        }

        // Paginate results
        $data['tenders'] = $tenders->paginate(10)->appends($request->query());

        // Fetch categories & companies for filters
        $data['categories'] = Category::all();
        $data['companies'] = Company::all();

        // If request is AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'html' => view('components.partials.listings', [
                    'records' => $data['tenders'],
                    'title' => 'tenders'
                ])->render(),
                'queryParams' => $request->query() // Return current query parameters
            ]);
        }

        // Return full view for non-AJAX requests
        return view('tenders.index', $data);

    }
    public function view(Request $request, $slug)
    {
        $tender = Tender::where('slug', $slug)->first();

        if (!$tender) {
            abort(404, 'Job not found');
        }

        // Process files: remove 'tenders/' from display name, and calculate file size
        $files = collect($tender->files)->map(function ($file) {
            $filePath = public_path('storage/' . $file);
            return [
                'original' => $file,
                'display' => str_replace('tenders/', '', $file),
                'url' => asset('storage/' . $file),
                'size' => file_exists($filePath) ? round(filesize($filePath) / 1024, 2) : null
            ];
        });

        $similar_tenders = Tender::with('company')
            ->where('slug', '!=', $slug)
            ->where('company_id', $tender->company_id)
            ->latest()
            ->take(5)
            ->get();

        return view('tenders.view', [
            'tender' => $tender,
            'similar_tenders' => $similar_tenders,
            'processedFiles' => $files
        ]);
    }

}
