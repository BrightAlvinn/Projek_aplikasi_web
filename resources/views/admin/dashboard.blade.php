<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth overflow-x-hidden bg-[#F8F9FB] dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-200">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin - CATATUANG</title>

    <!-- Theme Initialization Script (Sinkron dengan Landing Page) -->
    <script>
        if (localStorage.getItem('catatuang_theme') === 'dark' ||
            (!localStorage.getItem('catatuang_theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Google Fonts: Plus Jakarta Sans / Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS Play CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#4ABDAC',
                            hover: '#3ca092',
                            dark: '#2e7e73',
                            light: '#eaf7f5'
                        },
                        accent: {
                            yellow: '#F7B733',
                            red: '#FC4A1A'
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', '"Manrope"', 'sans-serif'],
                        heading: ['"Manrope"', '"Plus Jakarta Sans"', 'sans-serif']
                    }
                }
            }
        };
    </script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-heading { font-family: 'Manrope', sans-serif; }

        #sidebarDrawer {
            transition: transform 420ms cubic-bezier(0.22, 1, 0.36, 1);
        }
        #appShell {
            transition: transform 420ms cubic-bezier(0.22, 1, 0.36, 1),
                        margin-left 420ms cubic-bezier(0.22, 1, 0.36, 1),
                        box-shadow 420ms ease;
        }
        #appShell.is-shifted {
            box-shadow: -18px 0 40px -20px rgba(15, 23, 42, 0.25);
        }
        @media (prefers-reduced-motion: reduce) {
            #sidebarDrawer,
            #appShell { transition: none; }
        }
    </style>
</head>
<body class="bg-[#F8F9FB] dark:bg-slate-950 min-h-screen w-full overflow-x-hidden text-slate-800 dark:text-slate-200 antialiased selection:bg-[#4ABDAC]/25 selection:text-[#2e7e73] transition-colors duration-200">

    <!-- ======================================================== -->
    <!-- 1. SLIDE-OUT SIDEBAR ADMIN                               -->
    <!-- ======================================================== -->
    <div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-transparent" aria-hidden="true"></div>

    <aside id="sidebarDrawer" class="fixed top-0 left-0 bottom-0 z-50 w-[85vw] max-w-[20rem] sm:w-80 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col justify-between transform -translate-x-full" aria-label="Menu Admin CATATUANG" aria-hidden="true">
        <div class="flex-1 min-h-0 p-5 sm:p-6 space-y-6 overflow-y-auto">
            <!-- Brand Logo & Close Button -->
            <div class="flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-[#4ABDAC] text-white flex items-center justify-center shadow-md shadow-[#4ABDAC]/25 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="block text-lg font-extrabold font-heading text-[#4ABDAC] tracking-tight">CATATUANG</span>
                            <span class="px-1.5 py-0.5 text-[10px] font-extrabold uppercase rounded-md bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/30">Admin</span>
                        </div>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 font-medium">Panel Administrator</p>
                    </div>
                </a>

                <button id="sidebarCloseBtn" type="button" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition" aria-label="Tutup menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Navigation Links Khusus Admin -->
            <nav class="space-y-1.5" aria-label="Navigasi Admin">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 px-3 pb-1">Menu Administrator</p>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition bg-[#4ABDAC]/10 text-[#4ABDAC] border border-[#4ABDAC]/30 dark:bg-[#4ABDAC]/20">
                    <svg class="w-5 h-5 text-[#4ABDAC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard Admin</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom: ADMIN PROFILE & LOGOUT -->
        <div class="shrink-0 p-4 m-3 sm:m-4 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/90 dark:border-slate-700/80 space-y-3">
            <a href="{{ route('profile') }}" class="block p-2.5 rounded-xl hover:bg-white dark:hover:bg-slate-800 hover:shadow-xs border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition group" title="Buka Profil Admin">
                <div class="flex items-center gap-3">
                    <div class="relative shrink-0">
                        <div class="w-10 h-10 rounded-full bg-[#4ABDAC] text-white flex items-center justify-center font-bold text-sm shadow-xs group-hover:scale-105 transition-transform">
                            {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-800" title="Status: Online"></span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-1">
                            <span class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-[#4ABDAC]">Profil Admin</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <p class="text-xs font-semibold text-slate-700 dark:text-slate-300 truncate">{{ Auth::user()->name ?? 'Administrator' }}</p>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 truncate">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                </div>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 py-2 px-3 rounded-xl text-xs font-semibold text-rose-600 dark:text-rose-400 bg-rose-50/70 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/50 border border-rose-100 dark:border-rose-900/60 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ======================================================== -->
    <!-- 2. TOP HEADER NAVBAR ADMIN                               -->
    <!-- ======================================================== -->
    <div id="appShell" class="min-h-screen bg-[#F8F9FB] dark:bg-slate-950">
        <header class="bg-white/95 dark:bg-slate-900/95 backdrop-blur border-b border-slate-200 dark:border-slate-800 sticky top-0 z-30 shadow-xs transition-colors duration-200">
            <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3 min-w-0">
                    <button id="sidebarOpenBtn" type="button" aria-controls="sidebarDrawer" aria-expanded="false" class="p-2 -ml-1 rounded-xl text-slate-700 dark:text-slate-200 hover:text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xs transition shrink-0" aria-label="Buka menu slide" title="Buka Menu Navigasi">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <a href="{{ route('admin.dashboard') }}" class="hidden sm:flex items-center gap-2.5 shrink-0 pl-1 border-l border-slate-200 dark:border-slate-800">
                        <div class="w-8 h-8 rounded-lg bg-[#4ABDAC] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <span class="font-extrabold font-heading text-[#4ABDAC] tracking-tight text-sm">CATATUANG</span>
                    </a>

                    <div class="min-w-0 pl-1 sm:pl-3 border-l border-slate-200 dark:border-slate-800 flex items-center gap-2">
                        <h1 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white truncate tracking-tight">Dashboard Admin</h1>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-amber-500/15 text-amber-600 dark:text-amber-400 border border-amber-500/30">
                            Admin
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-2.5 shrink-0">
                    <!-- Theme Toggle -->
                    <button type="button" onclick="toggleTheme()" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:text-[#4ABDAC] dark:hover:text-[#4ABDAC] transition shadow-xs" title="Ganti Mode Gelap / Terang" aria-label="Ganti Tema">
                        <svg class="theme-icon-sun hidden w-5 h-5 text-[#F7B733]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg class="theme-icon-moon w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>

                    <!-- Date Badge -->
                    <div class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 text-xs font-semibold shadow-2xs">
                        <svg class="w-4 h-4 text-[#4ABDAC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="truncate">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- ======================================================== -->
        <!-- 3. MAIN CONTENT BODY DASHBOARD ADMIN                     -->
        <!-- ======================================================== -->
        <main class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-5 sm:py-7 space-y-5">
            @if (session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-4 py-3 rounded-2xl text-xs sm:text-sm flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 font-bold text-xs">&times;</button>
                </div>
            @endif

            <!-- Admin Info Card -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-5 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-[#4ABDAC] text-white flex items-center justify-center font-extrabold text-lg shadow-xs shrink-0">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h2 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white">
                                Selamat Datang, {{ Auth::user()->name ?? 'Administrator' }}
                            </h2>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                Role: {{ strtoupper(Auth::user()->role ?? 'admin') }}
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                            {{ Auth::user()->email ?? '' }} &bull; Anda masuk di halaman Dashboard khusus Administrator.
                        </p>
                    </div>
                </div>

                <form action="{{ route('logout') }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-900/50 border border-rose-200 dark:border-rose-800/60 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>

            <!-- Area Konten Dashboard Admin (Siap diisi fitur selanjutnya) -->
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-dashed border-slate-300 dark:border-slate-800 p-8 sm:p-12 text-center space-y-3">
                <div class="w-14 h-14 rounded-2xl bg-[#4ABDAC]/10 text-[#4ABDAC] flex items-center justify-center mx-auto">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white">
                    Halaman Dashboard Khusus Admin
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 max-w-md mx-auto">
                    Autentikasi role <strong>Admin</strong> telah aktif. Area ini siap ditambahkan komponen dan modul administrasi sesuai kebutuhan tim.
                </p>
            </div>
        </main>
    </div>

    <script>
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('catatuang_theme', isDark ? 'dark' : 'light');
            updateThemeIcons();
        }

        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            document.querySelectorAll('.theme-icon-sun').forEach(el => el.classList.toggle('hidden', !isDark));
            document.querySelectorAll('.theme-icon-moon').forEach(el => el.classList.toggle('hidden', isDark));
        }
        document.addEventListener('DOMContentLoaded', updateThemeIcons);

        const sidebarDrawer = document.getElementById('sidebarDrawer');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebarOpenBtn = document.getElementById('sidebarOpenBtn');
        const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
        const appShell = document.getElementById('appShell');
        const SIDEBAR_TRANSITION_MS = 420;
        const DOCKED_SIDEBAR_QUERY = window.matchMedia('(min-width: 768px)');
        let isSidebarOpen = false;
        let sidebarResetTimer = null;

        function applyOpenLayout() {
            const sidebarWidth = sidebarDrawer.offsetWidth;
            if (DOCKED_SIDEBAR_QUERY.matches) {
                appShell.style.transform = '';
                appShell.style.marginLeft = `${sidebarWidth}px`;
                appShell.classList.remove('is-shifted');
                sidebarOverlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                appShell.style.marginLeft = '';
                appShell.style.transform = `translateX(${sidebarWidth}px)`;
                appShell.classList.add('is-shifted');
                sidebarOverlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
        }

        function openSidebar() {
            clearTimeout(sidebarResetTimer);
            isSidebarOpen = true;
            sidebarDrawer.classList.remove('-translate-x-full');
            sidebarDrawer.setAttribute('aria-hidden', 'false');
            sidebarOpenBtn?.setAttribute('aria-expanded', 'true');
            applyOpenLayout();
        }

        function closeSidebar() {
            if (!isSidebarOpen) return;
            isSidebarOpen = false;
            sidebarDrawer.classList.add('-translate-x-full');
            sidebarDrawer.setAttribute('aria-hidden', 'true');
            sidebarOpenBtn?.setAttribute('aria-expanded', 'false');
            sidebarOverlay.classList.add('hidden');
            appShell.classList.remove('is-shifted');
            if (appShell.style.transform) appShell.style.transform = 'translateX(0)';
            if (appShell.style.marginLeft) appShell.style.marginLeft = '0px';
            document.body.classList.remove('overflow-hidden');
            sidebarResetTimer = setTimeout(() => {
                appShell.style.transform = '';
                appShell.style.marginLeft = '';
            }, SIDEBAR_TRANSITION_MS);
        }

        function toggleSidebar() {
            isSidebarOpen ? closeSidebar() : openSidebar();
        }

        if (sidebarOpenBtn) sidebarOpenBtn.addEventListener('click', toggleSidebar);
        if (sidebarCloseBtn) sidebarCloseBtn.addEventListener('click', closeSidebar);
        if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);
        DOCKED_SIDEBAR_QUERY.addEventListener('change', () => {
            if (isSidebarOpen) applyOpenLayout();
        });
        window.addEventListener('resize', (e) => {
            if (isSidebarOpen && e.isTrusted) applyOpenLayout();
        });
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeSidebar();
        });
    </script>
</body>
</html>

