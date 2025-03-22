<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
//Route::get('/login', [HomeController::class, 'index'])->name('login');

Route::group(['middleware' => ['web'],'prefix'=>'jobs','as'=>'jobs.'], function () {
Route::get('/', [JobController::class, 'index'])->name('index');
Route::get('/view/{slug}', [JobController::class, 'view'])->name('view');
Route::post('/bug/{slug}', [JobController::class, 'bug'])->name('bug');
});

Route::group(['middleware' => ['web'],'prefix'=>'tenders','as'=>'tenders.'], function () {
    Route::get('/', [\App\Http\Controllers\TenderController::class, 'index'])->name('index');
});

