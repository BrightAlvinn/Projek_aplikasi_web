<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth overflow-x-hidden bg-[#F8F9FB] dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-200">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - CATATUANG</title>

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

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-heading { font-family: 'Manrope', sans-serif; }

        /* Efek geser: sidebar masuk & halaman bergeser ke samping */
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

        @media print {
            header, aside, #sidebarOverlay, .no-print { display: none !important; }
            #appShell { transform: none !important; margin-left: 0 !important; }
            main { padding: 0 !important; max-width: 100% !important; }
            body { background: white !important; color: black !important; }
        }
    </style>
</head>
<body class="bg-[#F8F9FB] dark:bg-slate-950 min-h-screen w-full overflow-x-hidden text-slate-800 dark:text-slate-200 antialiased selection:bg-[#4ABDAC]/25 selection:text-[#2e7e73] transition-colors duration-200">

    <!-- ======================================================== -->
    <!-- 1. SLIDE-OUT SIDEBAR (DRAWER) & BACKDROP                 -->
    <!-- ======================================================== -->
    <!-- Overlay transparan: tidak menggelapkan layar, hanya menangkap klik/tap untuk menutup menu -->
    <div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-transparent no-print" aria-hidden="true"></div>

    <aside id="sidebarDrawer" class="fixed top-0 left-0 bottom-0 z-50 w-[85vw] max-w-[20rem] sm:w-80 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col justify-between transform -translate-x-full no-print" aria-label="Menu Utama CATATUANG" aria-hidden="true">
        
        <!-- Top Section Sidebar -->
        <div class="flex-1 min-h-0 p-5 sm:p-6 space-y-6 overflow-y-auto">
            <!-- Brand Logo & Close Button -->
            <div class="flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-[#4ABDAC] text-white flex items-center justify-center shadow-md shadow-[#4ABDAC]/25 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <span class="block text-lg font-extrabold font-heading text-[#4ABDAC] tracking-tight">CATATUANG</span>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 font-medium">Kelola Uang Makin Gampang</p>
                    </div>
                </a>

                <!-- Close Button -->
                <button id="sidebarCloseBtn" type="button" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition" aria-label="Tutup menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- "+ Catat Transaksi" Main Action Button -->
            <a href="{{ route('transactions.create') }}" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-xl bg-[#4ABDAC] hover:bg-[#3ca092] text-white font-bold text-sm shadow-md shadow-[#4ABDAC]/20 transition group">
                <svg class="w-4 h-4 text-white group-hover:rotate-90 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
                <span>+ Catat Transaksi</span>
            </a>

            <!-- Navigation Links -->
            <nav class="space-y-1.5" aria-label="Navigasi Menu">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 px-3 pb-1">Menu Utama</p>

                <!-- 1. Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition {{ request()->routeIs('dashboard') ? 'bg-[#4ABDAC]/10 text-[#4ABDAC] border border-[#4ABDAC]/30 dark:bg-[#4ABDAC]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-[#4ABDAC]' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- 2. Transaksi -->
                <a href="{{ route('transactions.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition {{ request()->routeIs('transactions.*') ? 'bg-[#4ABDAC]/10 text-[#4ABDAC] border border-[#4ABDAC]/30 dark:bg-[#4ABDAC]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('transactions.*') ? 'text-[#4ABDAC]' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span>Transaksi</span>
                </a>

                <!-- 3. Kategori -->
                <a href="{{ route('categories.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition {{ request()->routeIs('categories.*') ? 'bg-[#4ABDAC]/10 text-[#4ABDAC] border border-[#4ABDAC]/30 dark:bg-[#4ABDAC]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('categories.*') ? 'text-[#4ABDAC]' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span>Kategori</span>
                </a>

                <!-- 4. Laporan -->
                <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition {{ request()->routeIs('reports.*') ? 'bg-[#4ABDAC]/10 text-[#4ABDAC] border border-[#4ABDAC]/30 dark:bg-[#4ABDAC]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('reports.*') ? 'text-[#4ABDAC]' : 'text-slate-400 dark:text-slate-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>Laporan</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom: USER PROFILE CARD (Diubah dari "Database Aktif" ke "Profil User") -->
        <div class="shrink-0 p-4 m-3 sm:m-4 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200/90 dark:border-slate-700/80 space-y-3">
            <a href="{{ route('profile') }}" class="block p-2.5 rounded-xl hover:bg-white dark:hover:bg-slate-800 hover:shadow-xs border border-transparent hover:border-slate-200 dark:hover:border-slate-700 transition group" title="Buka Profil Pengguna">
                <div class="flex items-center gap-3">
                    <div class="relative shrink-0">
                        <div class="w-10 h-10 rounded-full bg-[#4ABDAC] text-white flex items-center justify-center font-bold text-sm shadow-xs group-hover:scale-105 transition-transform">
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        </div>
                        <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-800" title="Status: Online"></span>
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center justify-between gap-1">
                            <span class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-[#4ABDAC]">Profil User</span>
                            <svg class="w-3.5 h-3.5 text-slate-400 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                        <p class="text-xs font-semibold text-slate-700 dark:text-slate-300 truncate">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 truncate">Klik untuk ke tampilan profil &rarr;</p>
                    </div>
                </div>
            </a>

            <!-- Tombol Keluar (Logout) -->
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


    <!-- Pembungkus halaman: digeser ke samping saat sidebar dibuka -->
    <div id="appShell" class="min-h-screen bg-[#F8F9FB] dark:bg-slate-950">

    <!-- ======================================================== -->
    <!-- 2. TOP HEADER NAVBAR                                     -->
    <!-- (Garis tiga di ujung kiri, Brand CATATUANG, Theme, Date) -->
    <!-- ======================================================== -->
    <header class="bg-white/95 dark:bg-slate-900/95 backdrop-blur border-b border-slate-200 dark:border-slate-800 sticky top-0 z-30 shadow-xs transition-colors duration-200 no-print">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-3">
            
            <!-- Left Side: Hamburger (garis tiga pada ujung kiri) + Brand CATATUANG + Page Title -->
            <div class="flex items-center gap-3 min-w-0">
                <!-- Hamburger Button (Garis Tiga pada Ujung Kiri) -->
                <button id="sidebarOpenBtn" type="button" aria-controls="sidebarDrawer" aria-expanded="false" class="p-2 -ml-1 rounded-xl text-slate-700 dark:text-slate-200 hover:text-slate-900 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xs transition shrink-0" aria-label="Buka menu slide" title="Buka Menu Navigasi">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                <!-- Brand CATATUANG Logo & Text -->
                <a href="{{ route('dashboard') }}" class="hidden sm:flex items-center gap-2.5 shrink-0 pl-1 border-l border-slate-200 dark:border-slate-800">
                    <div class="w-8 h-8 rounded-lg bg-[#4ABDAC] text-white flex items-center justify-center font-bold text-xs shadow-xs">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="font-extrabold font-heading text-[#4ABDAC] tracking-tight text-sm">CATATUANG</span>
                </a>

                <!-- Page Title -->
                <div class="min-w-0 pl-1 sm:pl-3 border-l border-slate-200 dark:border-slate-800">
                    <h1 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white truncate tracking-tight">@yield('page_title', 'Ringkasan Keuangan')</h1>
                </div>
            </div>

            <!-- Right Side: Theme Switcher (Kiri dari Tanggal) + Real-time Date Badge -->
            <div class="flex items-center gap-2 sm:gap-2.5 shrink-0">
                
                <!-- THEME TOGGLE BUTTON (Dark / Light Mode) SAMA SEPERTI DI LANDING PAGE -->
                <button type="button" onclick="toggleTheme()" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:text-[#4ABDAC] dark:hover:text-[#4ABDAC] transition shadow-xs" title="Ganti Mode Gelap / Terang" aria-label="Ganti Tema">
                    <!-- Sun Icon (Muncul saat Dark Mode aktif) -->
                    <svg class="theme-icon-sun hidden w-5 h-5 text-[#F7B733]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <!-- Moon Icon (Muncul saat Light Mode aktif) -->
                    <svg class="theme-icon-moon w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <!-- Date Badge (Real-time Date) -->
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
    <!-- 3. MAIN CONTENT BODY                                     -->
    <!-- ======================================================== -->
    <main class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-5 sm:py-7 space-y-5">
        
        <!-- Flash Message Success -->
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

        <!-- Flash Message Error -->
        @if (session('error'))
            <div class="bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 px-4 py-3 rounded-2xl text-xs sm:text-sm flex items-center justify-between shadow-xs">
                <div class="flex items-center gap-2.5">
                    <svg class="w-4 h-4 text-rose-600 dark:text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800 font-bold text-xs">&times;</button>
            </div>
        @endif

        @yield('content')
    </main>

    </div>
    <!-- /appShell -->


    <!-- ======================================================== -->
    <!-- 4. GLOBAL THEME & SLIDE DRAWER JAVASCRIPT               -->
    <!-- ======================================================== -->
    <script>
        // --- Dark/Light Mode Switcher Logic ---
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('catatuang_theme', isDark ? 'dark' : 'light');
            updateThemeIcons();
            // Trigger chart updates if exists
            if (typeof updateChartsTheme === 'function') {
                updateChartsTheme(isDark);
            }
        }

        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            document.querySelectorAll('.theme-icon-sun').forEach(el => el.classList.toggle('hidden', !isDark));
            document.querySelectorAll('.theme-icon-moon').forEach(el => el.classList.toggle('hidden', isDark));
        }
        document.addEventListener('DOMContentLoaded', updateThemeIcons);

        // --- Slide-Out Sidebar Logic ---
        // Tablet/desktop (>= 768px): konten menyusut mengisi sisa ruang di samping sidebar (tidak terpotong).
        // Mobile (< 768px): halaman didorong ke samping (push), tap area halaman untuk menutup.
        const sidebarDrawer = document.getElementById('sidebarDrawer');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebarOpenBtn = document.getElementById('sidebarOpenBtn');
        const sidebarCloseBtn = document.getElementById('sidebarCloseBtn');
        const appShell = document.getElementById('appShell');
        const SIDEBAR_TRANSITION_MS = 420;
        const DOCKED_SIDEBAR_QUERY = window.matchMedia('(min-width: 768px)');
        let isSidebarOpen = false;
        let sidebarResetTimer = null;

        function notifyLayoutChange() {
            // Beri tahu Chart.js dkk. agar menyesuaikan ukuran setelah lebar konten berubah
            setTimeout(() => window.dispatchEvent(new Event('resize')), SIDEBAR_TRANSITION_MS + 20);
        }

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
            notifyLayoutChange();
        }

        function closeSidebar() {
            if (!isSidebarOpen) return;
            isSidebarOpen = false;
            sidebarDrawer.classList.add('-translate-x-full');
            sidebarDrawer.setAttribute('aria-hidden', 'true');
            sidebarOpenBtn?.setAttribute('aria-expanded', 'false');
            sidebarOverlay.classList.add('hidden');
            appShell.classList.remove('is-shifted');
            if (appShell.style.transform) {
                appShell.style.transform = 'translateX(0)';
            }
            if (appShell.style.marginLeft) {
                appShell.style.marginLeft = '0px';
            }
            document.body.classList.remove('overflow-hidden');

            // Bersihkan style setelah animasi agar elemen position:fixed di dalam halaman (modal, dll.) tetap normal
            sidebarResetTimer = setTimeout(() => {
                appShell.style.transform = '';
                appShell.style.marginLeft = '';
            }, SIDEBAR_TRANSITION_MS);
            notifyLayoutChange();
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

    <!-- SweetAlert2 Pop Up Notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDark = document.documentElement.classList.contains('dark');
            const popupBg = isDark ? '#0f172a' : '#ffffff';
            const textColor = isDark ? '#f1f5f9' : '#1e293b';

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Masuk!',
                    text: "{{ session('success') }}",
                    background: popupBg,
                    color: textColor,
                    confirmButtonColor: '#4ABDAC',
                    confirmButtonText: 'Lanjutkan',
                    timer: 3500,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'rounded-2xl border border-slate-200 dark:border-slate-800 shadow-2xl',
                        confirmButton: 'rounded-xl font-bold px-6 py-2.5 text-sm shadow-md shadow-[#4ABDAC]/25'
                    }
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Pemberitahuan',
                    text: "{{ session('error') }}",
                    background: popupBg,
                    color: textColor,
                    confirmButtonColor: '#FC4A1A',
                    confirmButtonText: 'Tutup',
                    customClass: {
                        popup: 'rounded-2xl border border-slate-200 dark:border-slate-800 shadow-2xl',
                        confirmButton: 'rounded-xl font-bold px-6 py-2.5 text-sm shadow-md shadow-[#FC4A1A]/25'
                    }
                });
            @endif
        });
    </script>

    <!-- Format otomatis titik ribuan untuk input nominal (Rupiah) -->
    <script>
        (function () {
            function formatThousands(digits) {
                return digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            }

            function applyRupiahFormat(input) {
                const target = document.getElementById(input.dataset.rupiahTarget);
                const caretPos = input.selectionStart ?? input.value.length;
                const digitsBeforeCaret = input.value.slice(0, caretPos).replace(/\D/g, '').length;
                const digits = input.value.replace(/\D/g, '').replace(/^0+(?=\d)/, '');
                const formatted = formatThousands(digits);

                input.value = formatted;
                if (target) {
                    target.value = digits;
                }

                if (document.activeElement === input) {
                    let newCaret = 0;
                    let seenDigits = 0;
                    while (newCaret < formatted.length && seenDigits < digitsBeforeCaret) {
                        if (/\d/.test(formatted[newCaret])) {
                            seenDigits++;
                        }
                        newCaret++;
                    }
                    input.setSelectionRange(newCaret, newCaret);
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                document.querySelectorAll('[data-rupiah-input]').forEach((input) => {
                    const initial = String(input.value || '').split(/[.,]/)[0];
                    input.value = initial;
                    applyRupiahFormat(input);
                    input.addEventListener('input', () => applyRupiahFormat(input));
                });
            });
        })();
    </script>

    @stack('scripts')
</body>
</html>