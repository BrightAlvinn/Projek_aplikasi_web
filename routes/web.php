<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

// Rute Landing Page (Bebas dari dependensi database untuk tahap awal)
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/landing', function () {
    return redirect()->route('landing');
});

// Rute Autentikasi Publik
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('auth/google', [AuthController::class, 'googleLogin'])->name('auth.google');

// Tampilan Login & Register (jika pakai halaman tersendiri)
Route::view('login', 'auth.login')->name('login');
Route::view('register', 'auth.register')->name('register');

// Rute yang Memerlukan Login (Dilindungi Middleware Auth)
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
