<?php

use Illuminate\Support\Facades\Route;

// Rute Landing Page (Bebas dari dependensi database untuk tahap awal)
Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/landing', function () {
    return redirect()->route('landing');
});
