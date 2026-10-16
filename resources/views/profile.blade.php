@extends('layouts.app')

@section('title', 'Profil Pengguna')
@section('page_title', 'Profil Pengguna')

@section('content')

    <div class="max-w-3xl mx-auto space-y-6">

        @if (isset($errors) && $errors->any())
            <div class="bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 px-4 py-3 rounded-2xl text-xs sm:text-sm shadow-sm space-y-1">
                <p class="font-bold">Terjadi kesalahan input:</p>
                <ul class="list-disc list-inside text-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profile Card Overview -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 sm:p-8 transition-colors">
            <div class="flex flex-col sm:flex-row items-center gap-5 text-center sm:text-left">
                <div class="relative">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#4ABDAC] text-white flex items-center justify-center font-extrabold text-2xl sm:text-3xl shadow-md border-4 border-white dark:border-slate-800">
                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                    </div>
                    <span class="absolute bottom-1 right-1 w-5 h-5 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-800 flex items-center justify-center" title="Online"></span>
                </div>

                <div class="space-y-1 flex-1">
                    <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white">{{ $user->name }}</h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $user->email }}</p>
                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 pt-1 text-xs text-slate-500 dark:text-slate-400">
                        <span class="bg-[#4ABDAC]/10 text-[#4ABDAC] dark:bg-[#4ABDAC]/20 px-2.5 py-1 rounded-lg font-bold">Member CATATUANG</span>
                        <span>&bull;</span>
                        <span>Terdaftar sejak {{ $user->created_at ? $user->created_at->format('d M Y') : '2026' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm p-6 sm:p-8 space-y-6 transition-colors">
            <div>
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Perbarui Informasi Akun</h2>
                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Ubah nama lengkap, alamat email, atau perbarui kata sandi Anda</p>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">
                        Nama Lengkap
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">
                        Alamat Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm font-semibold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                    <h3 class="text-sm font-bold text-slate-800 dark:text-white mb-1">Ganti Kata Sandi (Opsional)</h3>
                    <p class="text-xs text-slate-400 dark:text-slate-500 mb-4">Kosongkan kolom di bawah jika Anda tidak ingin mengubah kata sandi.</p>

                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">
                                Kata Sandi Saat Ini
                            </label>
                            <input type="password" id="current_password" name="current_password" placeholder="••••••••"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="new_password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">
                                    Kata Sandi Baru
                                </label>
                                <input type="password" id="new_password" name="new_password" placeholder="Minimal 6 karakter"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                            </div>
                            <div>
                                <label for="new_password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400 mb-1.5">
                                    Konfirmasi Sandi Baru
                                </label>
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Ulangi sandi baru"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-4 flex items-center justify-end gap-3">
                    <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-sm font-semibold hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#4ABDAC] hover:bg-[#3ca092] text-white text-sm font-bold shadow-md shadow-[#4ABDAC]/20 transition inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </div>
            </form>
        </div>

    </div>

@endsection
