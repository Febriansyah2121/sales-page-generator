<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesPageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WhatsAppVerificationController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Route profile (LENGKAPI)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route sales pages (dengan verifikasi WhatsApp)
Route::middleware(['auth', 'phone.verified'])->group(function () {
    Route::resource('sales-pages', SalesPageController::class);
    Route::get('/sales-pages/{id}/edit', [SalesPageController::class, 'edit'])->name('sales-pages.edit');
    Route::put('/sales-pages/{id}', [SalesPageController::class, 'update'])->name('sales-pages.update');
});

// ========== ADMIN ROUTES ==========
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/sales-pages', [AdminController::class, 'salesPages'])->name('sales-pages');
    Route::delete('/sales-pages/{id}', [AdminController::class, 'deleteSalesPage'])->name('sales-pages.delete');
});

// ========== WHATSAPP VERIFICATION ROUTES ==========
Route::middleware(['auth'])->group(function () {
    Route::get('/verify-whatsapp', [WhatsAppVerificationController::class, 'show'])->name('whatsapp.verify');
    Route::post('/send-otp', [WhatsAppVerificationController::class, 'sendOTP'])->name('send.otp');
    Route::post('/verify-otp', [WhatsAppVerificationController::class, 'verifyOTP'])->name('verify.otp');
    Route::post('/resend-otp', [WhatsAppVerificationController::class, 'resendOTP'])->name('resend.otp');
});

require __DIR__.'/auth.php';