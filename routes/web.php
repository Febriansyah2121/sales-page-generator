<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesPageController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Route profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route sales pages
Route::middleware(['auth'])->group(function () {
    Route::resource('sales-pages', SalesPageController::class);
});

require __DIR__.'/auth.php';