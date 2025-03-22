<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['jobs']=Job::with('company')->latest(10)->get();
        return view('home',$data);
    }
}
