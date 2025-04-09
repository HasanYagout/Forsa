<?php

namespace App\Http\Controllers;

use App\Filament\Resources\BannerResource;
use App\Models\Banner;
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
        $data['banners']=Banner::all();
        $data['categories']=Category::all();

        return view('dashboard',$data);
    }

}
