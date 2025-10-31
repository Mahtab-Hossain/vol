<?php

use App\Http\Controllers\OpportunityController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // added to fetch leaderboard

// Public routes (at the top, before Auth::routes())
Route::get('/how-it-works', function () {
    return view('how-it-works');
})->name('how-it-works');

Route::get('/leaderboard', [App\Http\Controllers\LeaderboardController::class, 'index'])->name('leaderboard');

// Google login routes
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback'])->name('login.google.callback');

Route::get('/', function () {
    // Leaderboard for landing page: top volunteers by points then tasks
    $leaderboard = User::where('role', 'volunteer')
        ->orderBy('points', 'desc')
        ->orderBy('tasks_completed', 'desc')
        ->take(6)
        ->get();

    return view('welcome', compact('leaderboard'));
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/opportunities', [OpportunityController::class, 'index'])->name('opportunities.index');
    Route::get('/opportunities/create', [OpportunityController::class, 'create'])->name('opportunities.create');
    Route::post('/opportunities', [OpportunityController::class, 'store'])->name('opportunities.store');
    Route::post('/opportunities/{id}/claim', [OpportunityController::class, 'claim'])->name('opportunities.claim');
    Route::post('/opportunities/{id}/complete', [OpportunityController::class, 'complete'])->name('opportunities.complete');
    Route::post('/opportunities/{id}/approve-cert', [App\Http\Controllers\ProfileController::class, 'approveCertification'])->name('certification.approve');
    Route::get('/opportunities/{id}/testimonial', [OpportunityController::class, 'showTestimonial'])->name('opportunities.testimonial.form');
    Route::post('/opportunities/{id}/testimonial', [App\Http\Controllers\OpportunityController::class, 'storeTestimonial'])->name('opportunities.testimonial');
    Route::get('/certificates/{id}/download', [App\Http\Controllers\ProfileController::class, 'downloadCertificate'])->name('certificates.download');
});