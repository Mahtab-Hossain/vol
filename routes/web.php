<?php

use App\Http\Controllers\OpportunityController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
    
});