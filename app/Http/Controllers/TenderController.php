<?php

namespace App\Http\Controllers;

use App\Helpers\Location;
use App\Models\Category;
use App\Models\Company;
use App\Models\Tender;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    public function index(Request $request)
    {
        $tenders = Tender::with(['company'])->available()->orderBy('created_at', 'desc');

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

        $data['companies'] = Company::whereHas('tenders', function($query) use ($request) {
            $query->available();
            if ($request->has('location') && !empty($request->location)) {
                $searchTerm = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request->location));
                $query->where(function($q) use ($searchTerm) {
                    $q->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(location, '''', ''), ' ', ''), '-', '')) LIKE ?", ['%' . $searchTerm . '%']);
                });
            }
        })->get();
        $existingLocations = Tender::query()
            ->when($request->filled('company'), function($query) use ($request) {
                $query->where('company_id', (int) $request->company);
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
            ->active()
            ->take(5)
            ->get();

        return view('tenders.view', [
            'tender' => $tender,
            'similar_tenders' => $similar_tenders,
            'processedFiles' => $files
        ]);
    }

}
