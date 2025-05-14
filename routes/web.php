<?php

use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

// Group all routes that require the SetLocale middleware
Route::middleware([\App\Http\Middleware\SetLocale::class])->group(function () {
    // Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about_us', [HomeController::class, 'about_us'])->name('about_us');
Route::get('/contact_us', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [\App\Http\Controllers\ContactController::class, 'store']) ->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->name('contact.store');

    // Bookmarks Routes
    Route::post('/bookmarks', [BookmarkController::class, 'toggle'])
        ->middleware('auth')
        ->name('bookmarks.toggle');
    Route::get('/bookmarks/show', [BookmarkController::class, 'show'])
        ->name('bookmark.show');

    // Jobs Routes
    Route::group(['middleware' => ['web'], 'prefix' => 'jobs', 'as' => 'jobs.'], function () {
        Route::get('/', [JobController::class, 'index'])->name('index');
        Route::get('/view/{slug}', [JobController::class, 'view'])->name('view');
    });

    // Trainings Routes
    Route::group(['middleware' => ['web'], 'prefix' => 'trainings', 'as' => 'trainings.'], function () {
        Route::get('/', [\App\Http\Controllers\TrainingController::class, 'index'])->name('index');
        Route::get('/view/{slug}', [\App\Http\Controllers\TrainingController::class, 'view'])->name('view');
    });

    Route::group(['middleware' => ['web'],'prefix'=>'tenders','as'=>'tenders.'], function () {
    Route::get('/', [\App\Http\Controllers\TenderController::class, 'index'])->name('index');
    Route::get('/view/{slug}', [\App\Http\Controllers\TenderController::class, 'view'])->name('view');
});
});

// Language Switch Route
Route::get('language/{locale}', [HomeController::class, 'switchLanguage'])->name('language.switch');
