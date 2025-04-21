<?php

namespace App\Http\Controllers;

use App\Filament\Resources\BannerResource;
use App\Models\Banner;
use App\Models\Contact;
use App\Models\Category;
use App\Models\Job;
use App\Models\Tender;
use App\Models\Training;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['tenders']=Tender::with('company')->active()->latest()->take(12)->get();
        $data['jobs']=Job::with('company')->active()->latest()->take(12)->get();
        $data['trainings']=Training::with('company')->active()->latest()->take(12)->get();
        $data['banner']=Banner::active()->first();
        $data['categories']=Category::get();
        $data['availableLocations']=Job::LOCATIONS;
        return view('dashboard',$data);
    }

    public function about_us()
    {
        return view('about_us');
    }



}
