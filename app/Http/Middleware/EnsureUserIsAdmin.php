<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Memastikan hanya pengguna dengan role admin yang dapat mengakses rute ini.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak! Halaman tersebut khusus untuk Admin.');
        }

        return $next($request);
    }
}

