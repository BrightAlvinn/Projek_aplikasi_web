<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Menampilkan halaman Dashboard khusus Admin.
     */
    public function index(Request $request): View
    {
        return view('admin.dashboard', [
            'admin' => $request->user(),
        ]);
    }
}

