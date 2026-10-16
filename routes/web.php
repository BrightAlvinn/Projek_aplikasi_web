<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;

// Rute Landing Page (Bebas dari dependensi database untuk tahap awal)
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/landing', function () {
    return redirect()->route('landing');
});

// Rute Autentikasi Publik
Route::get('login', function () {
    return redirect()->route('landing');
})->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('auth/google', [AuthController::class, 'googleLogin'])->name('auth.google');


// Rute yang Memerlukan Login (Dilindungi Middleware Auth)
Route::middleware('auth')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute Profil Pengguna
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    // Rute Ekspor Transaksi
    Route::get('transactions/export/csv', [TransactionController::class, 'exportCsv'])->name('transactions.export');

    // Rute CRUD Transaksi
    Route::resource('transactions', TransactionController::class);

    // Rute Manajemen Kategori
    Route::resource('categories', CategoryController::class)->except(['show', 'create', 'edit']);

    // Rute Laporan & Analitik Keuangan
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
});

