<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Memproses login pengguna.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $remember = $request->boolean('remember');
        $loginInput = trim($credentials['email']);

        // Mendukung login via Email maupun Username (name)
        $fieldType = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        // Cek apakah akun terdaftar berdasarkan Username atau Email
        $user = User::where($fieldType, $loginInput)->first();

        if (! $user) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Username atau Email tidak terdaftar dalam sistem!')
                ->withErrors([
                    'email' => 'Username atau Email tidak terdaftar.',
                ]);
        }

        // Cek apakah kata sandi cocok
        if (! Hash::check($credentials['password'], $user->password)) {
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Kata sandi yang Anda masukkan salah!')
                ->withErrors([
                    'password' => 'Kata sandi tidak sesuai dengan akun ini.',
                ]);
        }

        // Login pengguna
        Auth::login($user, $remember);
        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'))
            ->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
    }

    /**
     * Memproses pendaftaran akun baru.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $defaultCategories = [
            ['name' => 'Gaji Bulanan', 'type' => 'income', 'color' => '#10b981'],
            ['name' => 'Bonus & THR', 'type' => 'income', 'color' => '#06b6d4'],
            ['name' => 'Investasi & Usaha', 'type' => 'income', 'color' => '#8b5cf6'],
            ['name' => 'Makanan & Minuman', 'type' => 'expense', 'color' => '#ef4444'],
            ['name' => 'Transportasi & Bensin', 'type' => 'expense', 'color' => '#f97316'],
            ['name' => 'Belanja & Hiburan', 'type' => 'expense', 'color' => '#ec4899'],
            ['name' => 'Tagihan & Listrik', 'type' => 'expense', 'color' => '#64748b'],
        ];

        foreach ($defaultCategories as $category) {
            $user->categories()->create($category + ['icon' => 'tag']);
        }

        // Langsung otomatis login setelah daftar
        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')
            ->with('success', 'Akun berhasil didaftarkan! Selamat datang.');
    }

    /**
     * Memproses logout pengguna.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil keluar.');
    }
}
