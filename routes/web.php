<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminDefaultCategoryController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// Rute Landing Page (Bebas dari dependensi database untuk tahap awal)
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/landing', function () {
    return redirect()->route('landing');
});

// Rute Autentikasi Publik
Route::get('login', function () {
    return redirect()->route('landing', ['auth' => 'login']);
})->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.post');
Route::post('register', [AuthController::class, 'register'])->name('register.post');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang Memerlukan Login (Dilindungi Middleware Auth & Status Aktif)
Route::middleware(['auth', 'active'])->group(function () {
    // Rute Khusus Admin
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('monitoring/check-ai', [AdminDashboardController::class, 'checkAiStatus'])->name('monitoring.check-ai');
        Route::post('monitoring/clear-log', [AdminDashboardController::class, 'clearLog'])->name('monitoring.clear-log');

        // Manajemen Pengguna
        Route::patch('users/{user}/toggle-status', [AdminUserController::class, 'toggleStatus'])->name('users.toggle-status');
        Route::patch('users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.update-role');
        Route::delete('users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

        // Master Kategori Default
        Route::post('default-categories', [AdminDefaultCategoryController::class, 'store'])->name('default-categories.store');
        Route::put('default-categories/{defaultCategory}', [AdminDefaultCategoryController::class, 'update'])->name('default-categories.update');
        Route::delete('default-categories/{defaultCategory}', [AdminDefaultCategoryController::class, 'destroy'])->name('default-categories.destroy');
    });

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

    // Rute Asisten Keuangan AI (Chatbot)
    Route::post('chatbot/chat', [ChatbotController::class, 'chat'])
        ->middleware('throttle:20,1')
        ->name('chatbot.chat');
});
