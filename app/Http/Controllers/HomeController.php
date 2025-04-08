<?php

namespace App\Http\Controllers;

use App\Filament\Resources\BannerResource;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Job;
use App\Models\Tender;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['tenders']=Tender::with('company')->latest()->take(6)->get();
        $data['jobs']=Job::with('company')->latest()->take(6)->get();
        $data['banners']=Banner::all();
        $data['categories']=Category::all();

        return view('dashboard',$data);
    }
    public function home()
    {

        $data['tenders']=Tender::with('company')->latest()->take(6)->get();
        $data['jobs'] = Job::with('company')->latest()->take(6)->get();
        $data['banners']=Banner::all();
        $data['categories']=Category::all();
        return view('dashboard',$data);
    }
}
