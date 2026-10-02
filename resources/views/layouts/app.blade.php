<form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="text-red-500 hover:underline">
        Keluar
    </button>
</form>

<!-- Taruh di bagian bawah Sidebar (sebelum </aside>) -->
        <div class="p-4 m-4 border-t border-slate-200 dark:border-slate-800">
            <!-- Info Pengguna yang sedang login -->
            <div class="flex items-center gap-3 mb-3">
                <div class="w-9 h-9 rounded-full bg-teal-500 text-white flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="truncate">
                    <p class="text-sm font-semibold text-slate-800 dark:text-white truncate">
                        {{ Auth::user()->name ?? 'Pengguna' }}
                    </p>
                    <p class="text-xs text-slate-400 truncate">
                        {{ Auth::user()->email ?? '' }}
                    </p>
                </div>
            </div>

            <!-- Tombol Logout -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-xl text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 dark:bg-red-950/30 dark:hover:bg-red-900/50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>