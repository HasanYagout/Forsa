<?php

namespace App\Http\Controllers;

use App\Filament\Resources\BannerResource;
use App\Models\Banner;
use App\Models\Bug;
use App\Models\Category;
use App\Models\Job;
use App\Models\Tender;
use App\Models\Training;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['tenders']=Tender::with('company')->latest()->take(12)->get();
        $data['jobs']=Job::with('company')->latest()->take(12)->get();
        $data['trainings']=Training::with('company')->latest()->take(12)->get();
        $data['banner']=Banner::where('status',1)->first();
        $data['categories']=Category::all();
        return view('dashboard',$data);
    }

    public function about_us()
    {
        return view('about_us');
    }
    public function contact_us()
    {
        return view('contact_us');
    }
    public function bug(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email', // Corrected validation rule
                'type' => 'required',
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
