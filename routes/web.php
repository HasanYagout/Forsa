<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
});

Route::post('/bookmarks', [BookmarkController::class, 'toggle'])
    ->middleware('auth')
    ->name('bookmarks.toggle');
Route::get('/bookmarks/show', [BookmarkController::class, 'show'])
    ->name('bookmark.show');
    Route::get('/dashboard', [HomeController::class,'index'])->name('dashboard');
Route::group(['middleware' => ['web'],'prefix'=>'jobs','as'=>'jobs.'], function () {
    Route::get('/', [JobController::class, 'index'])->name('index');
    Route::get('/view/{slug}', [JobController::class, 'view'])->name('view');
    Route::post('/bug/{slug}', [JobController::class, 'bug'])->name('bug');
});

Route::group(['middleware' => ['web'],'prefix'=>'tenders','as'=>'tenders.'], function () {
    Route::get('/', [\App\Http\Controllers\TenderController::class, 'index'])->name('index');
    Route::get('/view/{slug}', [\App\Http\Controllers\TenderController::class, 'view'])->name('view');
});

Route::group(['middleware' => ['web'],'prefix'=>'trainigns','as'=>'trainings.'], function () {
    Route::get('/', [\App\Http\Controllers\TrainingController::class, 'index'])->name('index');
    Route::get('/view/{slug}', [\App\Http\Controllers\TrainingController::class, 'view'])->name('view');
});

