<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::group(['middleware' => ['web'],'prefix'=>'jobs','as'=>'jobs.'], function () {
Route::get('/', [JobController::class, 'index'])->name('index');
});

