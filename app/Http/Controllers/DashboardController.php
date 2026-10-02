<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard utama.
     */
    public function index(Request $request)
    {
        return view('dashboard');
    }
}
