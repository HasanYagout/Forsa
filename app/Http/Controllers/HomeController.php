<?php

namespace App\Http\Controllers;

use App\Filament\Resources\BannerResource;
use App\Helpers\Location;
use App\Models\Banner;
use App\Models\Contact;
use App\Models\Category;
use App\Models\Job;
use App\Models\Tender;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
//        $data['tenders']=Tender::with('company')->available()->latest()->take(12)->get();
        $data['jobs']=Job::with('company')->available()->latest()->take(12)->get();
        $data['trainings']=Training::with('company')->available()->latest()->take(12)->get();
        $data['banner']=Banner::available()->first();
        $data['categories']=Category::get();
        $data['availableLocations'] = collect(Location::cities())->flatten()->unique()->values()->toArray();
        return view('dashboard',$data);
    }

    public function about_us()
    {
        return view('about_us');
    }

    public function switchLanguage($locale)
    {
        $availableLocales = ['en', 'ar'];
        if (in_array($locale, $availableLocales)) {
            Session::put('locale', $locale);
            Session::put('dir', $locale === 'ar' ? 'rtl' : 'ltr');
            App::setLocale($locale);
        }


        return Redirect::back();
    }

}
