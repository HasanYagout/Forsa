<?php

use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::group(['middleware' => ['web'],'prefix'=>'jobs','as'=>'jobs.'], function () {
Route::get('/', [JobController::class, 'index'])->name('index');
Route::get('/view/{slug}', [JobController::class, 'view'])->name('view');
});

Route::group(['middleware' => ['web'],'prefix'=>'tenders','as'=>'tenders.'], function () {
    Route::get('/', [\App\Http\Controllers\TenderController::class, 'index'])->name('index');
});

