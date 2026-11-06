<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth overflow-x-hidden bg-[#F8F9FB] dark:bg-slate-950 text-slate-800 dark:text-slate-100 transition-colors duration-200">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Admin - CATATUANG</title>

    <!-- Theme Initialization Script -->
    <script>
        if (localStorage.getItem('catatuang_theme') === 'dark' ||
            (!localStorage.getItem('catatuang_theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
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

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: rgba(148, 163, 184, 0.3);
            border-radius: 9999px;
        }
    </style>
</head>
<body class="bg-[#F8F9FB] dark:bg-slate-950 min-h-screen w-full overflow-x-hidden text-slate-800 dark:text-slate-200 antialiased selection:bg-[#4ABDAC]/25 selection:text-[#2e7e73] transition-colors duration-200">

    <!-- ======================================================== -->
    <!-- SIDEBAR DRAWER ADMIN                                      -->
    <!-- ======================================================== -->
    <div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-transparent" aria-hidden="true"></div>

    <aside id="sidebarDrawer" class="fixed top-0 left-0 bottom-0 z-50 w-[85vw] max-w-[20rem] sm:w-80 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col justify-between transform -translate-x-full" aria-label="Menu Admin CATATUANG" aria-hidden="true">
        <div class="flex-1 min-h-0 p-5 sm:p-6 space-y-6 overflow-y-auto custom-scrollbar">
            <!-- Brand Logo -->
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
            </div>

            <!-- Navigation Links Khusus Admin -->
            <nav class="space-y-1.5" aria-label="Navigasi Admin">
                <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 px-3 pb-1">Navigasi Modul</p>

                <a href="#section-kpi" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    <svg class="w-4 h-4 text-[#4ABDAC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    <span>1. Ringkasan KPI</span>
                </a>

                <a href="#section-analytics" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>2. Grafik & Analitik</span>
                </a>

                <a href="#section-users" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>3. Manajemen Pengguna</span>
                </a>

                <a href="#section-templates" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span>4. Master Kategori Default</span>
                </a>

                <a href="#section-monitoring" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span>5. Monitoring AI & Sistem</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom: Admin Profile & Logout -->
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
    <!-- TOP HEADER NAVBAR ADMIN                                   -->
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

                    <a id="headerBrandLogo" href="{{ route('admin.dashboard') }}" class="hidden sm:flex items-center gap-2.5 shrink-0 pl-1 border-l border-slate-200 dark:border-slate-800">
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
                    <!-- Quick Jump Links (Desktop) -->
                    <div class="hidden lg:flex items-center gap-1.5 bg-slate-100 dark:bg-slate-800 p-1 rounded-xl text-xs font-semibold">
                        <a href="#section-kpi" class="px-2.5 py-1 rounded-lg text-slate-600 dark:text-slate-300 hover:text-slate-900 hover:bg-white dark:hover:bg-slate-700 transition">KPI</a>
                        <a href="#section-analytics" class="px-2.5 py-1 rounded-lg text-slate-600 dark:text-slate-300 hover:text-slate-900 hover:bg-white dark:hover:bg-slate-700 transition">Grafik</a>
                        <a href="#section-users" class="px-2.5 py-1 rounded-lg text-slate-600 dark:text-slate-300 hover:text-slate-900 hover:bg-white dark:hover:bg-slate-700 transition">Pengguna</a>
                        <a href="#section-templates" class="px-2.5 py-1 rounded-lg text-slate-600 dark:text-slate-300 hover:text-slate-900 hover:bg-white dark:hover:bg-slate-700 transition">Kategori</a>
                        <a href="#section-monitoring" class="px-2.5 py-1 rounded-lg text-slate-600 dark:text-slate-300 hover:text-slate-900 hover:bg-white dark:hover:bg-slate-700 transition">Monitoring</a>
                    </div>

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
        <!-- MAIN CONTENT BODY                                         -->
        <!-- ======================================================== -->
        <main class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 py-6 space-y-8">

            <!-- Flash Alert Messages -->
            @if (session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-4 py-3 rounded-2xl text-xs sm:text-sm flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 font-bold text-lg leading-none">&times;</button>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 px-4 py-3 rounded-2xl text-xs sm:text-sm flex items-center justify-between shadow-xs">
                    <div class="flex items-center gap-2.5">
                        <svg class="w-5 h-5 text-rose-600 dark:text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-800 font-bold text-lg leading-none">&times;</button>
                </div>
            @endif

            <!-- Welcome Admin Banner -->
            <div class="bg-gradient-to-r from-teal-600 to-[#4ABDAC] rounded-3xl p-6 sm:p-7 text-white shadow-lg shadow-[#4ABDAC]/15 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 rounded-2xl bg-white/20 backdrop-blur border border-white/30 flex items-center justify-center font-extrabold text-2xl shadow-inner shrink-0">
                        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h2 class="text-lg sm:text-xl font-extrabold font-heading">
                                Halo, {{ Auth::user()->name ?? 'Administrator' }}!
                            </h2>
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/25 text-white backdrop-blur border border-white/30 uppercase tracking-wider">
                                Superadmin Panel
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-white/85 mt-1">
                            Pusat kendali ekosistem CATATUANG: Pantau pertumbuhan pengguna, analisis transaksi, kelola template kategori, dan awasi kesehatan AI.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 self-stretch sm:self-auto shrink-0">
                    <button type="button" onclick="pingAiChatbot()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white text-[#2e7e73] font-bold text-xs shadow-md hover:bg-slate-50 transition active:scale-95">
                        <svg id="pingAiBtnIcon" class="w-4 h-4 text-[#4ABDAC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span id="pingAiBtnText">Tes Koneksi AI</span>
                    </button>
                </div>
            </div>

            <!-- ======================================================== -->
            <!-- 1. RINGKASAN STATISTIK UTAMA (KPI CARDS)                  -->
            <!-- ======================================================== -->
            <section id="section-kpi" class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base sm:text-lg font-extrabold font-heading text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#4ABDAC]"></span>
                            1. Ringkasan Statistik Utama (KPI Platform)
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Ringkasan performa pengguna, transaksi, dan aset penyimpanan sistem.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- KPI 1: Total Pengguna -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-[#4ABDAC]/50 transition group">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Pengguna</span>
                            <div class="w-10 h-10 rounded-xl bg-teal-50 dark:bg-teal-950/50 text-[#4ABDAC] flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white font-heading">
                                {{ number_format($totalUsers) }}
                            </div>
                            <div class="mt-1.5 flex items-center gap-1.5 text-xs">
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-md font-bold text-[11px] bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                    +{{ $newUsersThisMonth }} baru
                                </span>
                                <span class="text-slate-400 dark:text-slate-500">bulan ini</span>
                            </div>
                        </div>
                    </div>

                    <!-- KPI 2: Pengguna Aktif -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-emerald-500/50 transition group">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pengguna Aktif</span>
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white font-heading">
                                {{ number_format($activeUsers7Days) }}
                            </div>
                            <div class="mt-1.5 flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400">
                                <span class="font-bold text-emerald-600 dark:text-emerald-400">7 hari</span>
                                <span>&bull;</span>
                                <span>{{ $activeUsers30Days }} aktif 30 hari</span>
                            </div>
                        </div>
                    </div>

                    <!-- KPI 3: Total Frekuensi Transaksi -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-amber-500/50 transition group">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Transaksi</span>
                            <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white font-heading">
                                {{ number_format($totalTransactions) }}
                            </div>
                            <div class="mt-1.5 flex items-center gap-1 text-[11px] text-slate-500 dark:text-slate-400 truncate">
                                <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ $incomeTransactionsCount }} Masuk</span>
                                <span>&bull;</span>
                                <span class="text-rose-600 dark:text-rose-400 font-semibold">{{ $expenseTransactionsCount }} Keluar</span>
                            </div>
                        </div>
                    </div>

                    <!-- KPI 4: Total Penggunaan Storage Bukti Foto -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs hover:border-purple-500/50 transition group">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Penggunaan Storage</span>
                            <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white font-heading">
                                {{ $storageStats['formatted'] }}
                            </div>
                            <div class="mt-1.5">
                                <div class="flex items-center justify-between text-[11px] text-slate-500 dark:text-slate-400 mb-1">
                                    <span>{{ $storageStats['count'] }} file struk</span>
                                    <span>{{ $storageStats['percentage'] }}% kuota</span>
                                </div>
                                <div class="w-full h-1.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                    <div class="h-full bg-purple-500 rounded-full" style="width: {{ max(4, $storageStats['percentage']) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======================================================== -->
            <!-- 2. GRAFIK & ANALITIK PLATFORM                             -->
            <!-- ======================================================== -->
            <section id="section-analytics" class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base sm:text-lg font-extrabold font-heading text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                            2. Grafik & Analitik Platform
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Visualisasi dinamika pertumbuhan pengguna, frekuensi transaksi, dan kategori favorit.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Chart 1: Pertumbuhan Pengguna Baru -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">Pertumbuhan Pengguna Baru</h3>
                                    <p class="text-[11px] text-slate-400">Registrasi akun baru</p>
                                </div>
                                <div class="inline-flex p-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-[11px] font-bold">
                                    <button type="button" id="btnUserMonthly" onclick="switchUserGrowth('monthly')" class="px-2 py-1 rounded-md bg-white dark:bg-slate-700 text-slate-800 dark:text-white shadow-xs">Bulanan</button>
                                    <button type="button" id="btnUserWeekly" onclick="switchUserGrowth('weekly')" class="px-2 py-1 rounded-md text-slate-500 hover:text-slate-800 dark:hover:text-white">Mingguan</button>
                                </div>
                            </div>
                            <div class="h-60 relative">
                                <canvas id="userGrowthChart"></canvas>
                            </div>
                        </div>
                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                            <span>Akumulasi Pengguna: <strong>{{ $totalUsers }}</strong></span>
                            <span class="text-[#4ABDAC] font-bold">+{{ $newUsersThisMonth }} bulan ini</span>
                        </div>
                    </div>

                    <!-- Chart 2: Tren Aktivitas Pencatatan Transaksi -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">Tren Aktivitas Transaksi</h3>
                                    <p class="text-[11px] text-slate-400">Pencatatan keuangan di sistem</p>
                                </div>
                                <div class="inline-flex p-0.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-[11px] font-bold">
                                    <button type="button" id="btnTxMonthly" onclick="switchTxTrend('monthly')" class="px-2 py-1 rounded-md bg-white dark:bg-slate-700 text-slate-800 dark:text-white shadow-xs">Bulanan</button>
                                    <button type="button" id="btnTxDaily" onclick="switchTxTrend('daily')" class="px-2 py-1 rounded-md text-slate-500 hover:text-slate-800 dark:hover:text-white">Harian (30h)</button>
                                </div>
                            </div>
                            <div class="h-60 relative">
                                <canvas id="txActivityChart"></canvas>
                            </div>
                        </div>
                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between text-xs text-slate-500 dark:text-slate-400">
                            <span>Total Frekuensi: <strong>{{ number_format($totalTransactions) }}</strong></span>
                            <span class="text-emerald-500 font-semibold">{{ $incomeTransactionsCount }} M / {{ $expenseTransactionsCount }} K</span>
                        </div>
                    </div>

                    <!-- Chart 3: Kategori Terpopuler Platform -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div>
                                    <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">Kategori Paling Sering Dipakai</h3>
                                    <p class="text-[11px] text-slate-400">Peringkat kategori seluruh user</p>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-[#4ABDAC]/10 text-[#4ABDAC] uppercase">Top 6</span>
                            </div>

                            <div class="space-y-3 mt-4">
                                @forelse ($popularCategories as $index => $cat)
                                    <div class="p-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 space-y-1.5">
                                        <div class="flex items-center justify-between text-xs">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <span class="w-5 h-5 rounded-md text-white font-extrabold text-[10px] flex items-center justify-center shrink-0 shadow-xs" style="background-color: {{ $cat->color }}">
                                                    {{ $index + 1 }}
                                                </span>
                                                <span class="font-bold text-slate-800 dark:text-slate-200 truncate">{{ $cat->name }}</span>
                                                <span class="text-[10px] px-1.5 py-0.2 rounded font-semibold {{ $cat->type === 'income' ? 'bg-emerald-100 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400' : 'bg-rose-100 dark:bg-rose-950 text-rose-700 dark:text-rose-400' }}">
                                                    {{ $cat->type === 'income' ? 'Masuk' : 'Keluar' }}
                                                </span>
                                            </div>
                                            <div class="text-right shrink-0">
                                                <span class="font-extrabold text-slate-900 dark:text-white">{{ $cat->total_usage }}x</span>
                                                <span class="text-[10px] text-slate-400">({{ $cat->percentage }}%)</span>
                                            </div>
                                        </div>
                                        <div class="w-full h-1.5 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                            <div class="h-full rounded-full" style="width: {{ max(4, $cat->percentage) }}%; background-color: {{ $cat->color }}"></div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-10 text-slate-400 text-xs">
                                        Belum ada data transaksi untuk dihitung.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 text-right text-[11px] text-slate-400">
                            Berdasarkan frekuensi transaksi pengguna aktif
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======================================================== -->
            <!-- 3. MANAJEMEN PENGGUNA (USER MANAGEMENT)                   -->
            <!-- ======================================================== -->
            <section id="section-users" class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h2 class="text-base sm:text-lg font-extrabold font-heading text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            3. Manajemen Pengguna (User Management)
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Kelola akun terdaftar, filter peran, penangguhan (suspend/unban), dan hak akses admin.</p>
                    </div>
                    <div class="text-xs text-slate-500">
                        Total: <span class="font-bold text-slate-900 dark:text-white">{{ $users->total() }}</span> pengguna
                    </div>
                </div>

                <!-- Card Pencarian & Filter -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl p-4 sm:p-5 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                    <form method="GET" action="{{ route('admin.dashboard') }}#section-users" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
                        <!-- Input Cari Nama / Email -->
                        <div class="sm:col-span-5 relative">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email pengguna..." class="w-full pl-9 pr-3 py-2 rounded-xl text-xs sm:text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC]">
                            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>

                        <!-- Filter Role -->
                        <div class="sm:col-span-3">
                            <select name="role" class="w-full px-3 py-2 rounded-xl text-xs sm:text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#4ABDAC]">
                                <option value="">Semua Peran (Role)</option>
                                <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User (Pengguna Biasa)</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin (Administrator)</option>
                            </select>
                        </div>

                        <!-- Filter Status -->
                        <div class="sm:col-span-2">
                            <select name="status" class="w-full px-3 py-2 rounded-xl text-xs sm:text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#4ABDAC]">
                                <option value="">Semua Status</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>

                        <!-- Action Buttons -->
                        <div class="sm:col-span-2 flex items-center gap-2">
                            <button type="submit" class="w-full py-2 px-3 rounded-xl bg-[#4ABDAC] hover:bg-[#3ca092] text-white font-bold text-xs shadow-xs transition">
                                Filter
                            </button>
                            @if (request()->hasAny(['search', 'role', 'status']))
                                <a href="{{ route('admin.dashboard') }}#section-users" class="py-2 px-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 text-xs font-bold transition" title="Reset Filter">
                                    &times;
                                </a>
                            @endif
                        </div>
                    </form>

                    <!-- Table Pengguna -->
                    <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-800">
                        <table class="w-full text-left text-xs sm:text-sm">
                            <thead class="bg-slate-50 dark:bg-slate-800/80 text-slate-500 dark:text-slate-400 font-bold uppercase text-[11px] tracking-wider border-b border-slate-200 dark:border-slate-800">
                                <tr>
                                    <th class="p-3.5">Pengguna</th>
                                    <th class="p-3.5">Peran (Role)</th>
                                    <th class="p-3.5">Status Akun</th>
                                    <th class="p-3.5">Tanggal Daftar</th>
                                    <th class="p-3.5">Aktivitas Transaksi</th>
                                    <th class="p-3.5 text-right">Aksi Manajemen</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse ($users as $userItem)
                                    <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                                        <!-- User Info -->
                                        <td class="p-3.5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-9 h-9 rounded-full bg-[#4ABDAC] text-white font-extrabold flex items-center justify-center text-xs shrink-0 shadow-xs">
                                                    {{ strtoupper(substr($userItem->name, 0, 1)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="flex items-center gap-1.5">
                                                        <span class="font-bold text-slate-900 dark:text-white truncate">{{ $userItem->name }}</span>
                                                        @if ($userItem->id === Auth::id())
                                                            <span class="px-1.5 py-0.2 rounded text-[10px] font-extrabold bg-blue-100 dark:bg-blue-950 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800">Anda</span>
                                                        @endif
                                                    </div>
                                                    <p class="text-slate-400 dark:text-slate-500 text-xs truncate">{{ $userItem->email }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Role -->
                                        <td class="p-3.5 whitespace-nowrap">
                                            @if ($userItem->isAdmin())
                                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                                    </svg>
                                                    Administrator
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                                                    User Biasa
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Status Akun -->
                                        <td class="p-3.5 whitespace-nowrap">
                                            @if ($userItem->isActive())
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                                    Suspended
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Tanggal Daftar -->
                                        <td class="p-3.5 whitespace-nowrap text-slate-600 dark:text-slate-300 text-xs">
                                            <div>{{ $userItem->created_at ? $userItem->created_at->isoFormat('D MMM YYYY') : '-' }}</div>
                                            <div class="text-[11px] text-slate-400">{{ $userItem->created_at ? $userItem->created_at->diffForHumans() : '' }}</div>
                                        </td>

                                        <!-- Total Transaksi -->
                                        <td class="p-3.5 whitespace-nowrap">
                                            <div class="font-extrabold text-slate-900 dark:text-white">
                                                {{ $userItem->transactions_count }} transaksi
                                            </div>
                                            <div class="text-[11px] text-slate-400">
                                                Masuk: Rp{{ number_format((float) ($userItem->total_income ?? 0), 0, ',', '.') }}
                                            </div>
                                        </td>

                                        <!-- Action Buttons -->
                                        <td class="p-3.5 whitespace-nowrap text-right">
                                            <div class="inline-flex items-center gap-1.5">
                                                @if ($userItem->id !== Auth::id())
                                                    <!-- Toggle Status (Suspend/Unban) -->
                                                    <form method="POST" action="{{ route('admin.users.toggle-status', $userItem) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        @if ($userItem->isActive())
                                                            <button type="button" onclick="confirmSuspendUser(this, '{{ $userItem->name }}')" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/50 border border-transparent hover:border-rose-200 dark:hover:border-rose-900 transition" title="Nonaktifkan (Suspend) Akun">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                                </svg>
                                                            </button>
                                                        @else
                                                            <button type="button" onclick="confirmActivateUser(this, '{{ $userItem->name }}')" class="p-1.5 rounded-lg text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/50 border border-transparent hover:border-emerald-200 dark:hover:border-emerald-900 transition" title="Aktifkan Kembali Akun">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                </svg>
                                                            </button>
                                                        @endif
                                                    </form>

                                                    <!-- Ubah Role (User <-> Admin) -->
                                                    <form method="POST" action="{{ route('admin.users.update-role', $userItem) }}" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="role" value="{{ $userItem->isAdmin() ? 'user' : 'admin' }}">
                                                        <button type="button" onclick="confirmChangeRole(this, '{{ $userItem->name }}', '{{ $userItem->isAdmin() ? 'User Biasa' : 'Administrator' }}')" class="p-1.5 rounded-lg text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-950/50 border border-transparent hover:border-amber-200 dark:hover:border-amber-900 transition" title="Ubah Role Akun">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                                                            </svg>
                                                        </button>
                                                    </form>

                                                    <!-- Hapus Akun -->
                                                    <form method="POST" action="{{ route('admin.users.destroy', $userItem) }}" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button" onclick="confirmDeleteUser(this, '{{ $userItem->name }}')" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/50 transition" title="Hapus Akun Permanen">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-[11px] text-slate-400 italic px-2">Akun Anda</span>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="p-8 text-center text-slate-400 text-xs">
                                            Tidak ada data pengguna yang sesuai dengan filter pencarian.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if ($users->hasPages())
                        <div class="pt-2">
                            {{ $users->links() }}
                        </div>
                    @endif
                </div>
            </section>

            <!-- ======================================================== -->
            <!-- 4. MASTER KATEGORI DEFAULT (TEMPLATE KATEGORI)            -->
            <!-- ======================================================== -->
            <section id="section-templates" class="space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h2 class="text-base sm:text-lg font-extrabold font-heading text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-violet-500"></span>
                            4. Master Kategori Default (Template Kategori)
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Kelola kategori bawaan (Pemasukan & Pengeluaran) yang otomatis diduplikasi ke akun user saat mereka mendaftar pertama kali.
                        </p>
                    </div>
                    <button type="button" onclick="openCreateDefaultCategoryModal()" class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl bg-violet-600 hover:bg-violet-700 text-white font-bold text-xs shadow-md transition self-start sm:self-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span>+ Tambah Template Baru</span>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Template Pemasukan (Income) -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                <h3 class="font-extrabold text-sm text-slate-900 dark:text-white">Template Pemasukan</h3>
                            </div>
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/50 px-2 py-0.5 rounded-md">
                                {{ $defaultIncomeCategories->count() }} Kategori
                            </span>
                        </div>

                        <div class="space-y-2.5">
                            @forelse ($defaultIncomeCategories as $category)
                                <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3 group hover:border-[#4ABDAC]/40 transition">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-extrabold shrink-0 shadow-xs" style="background-color: {{ $category->color }}">
                                            <span class="uppercase">{{ substr($category->name, 0, 1) }}</span>
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $category->name }}</h4>
                                            <div class="flex items-center gap-2 text-[10px] text-slate-400">
                                                <span>Warna: <code class="font-mono">{{ $category->color }}</code></span>
                                                <span>&bull;</span>
                                                <span>Ikon: {{ $category->icon ?: 'tag' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1 shrink-0">
                                        <button type="button" onclick="openEditDefaultCategoryModal({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ $category->type }}', '{{ $category->color }}', '{{ $category->icon }}')" class="p-1.5 rounded-lg text-slate-500 hover:text-slate-800 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-slate-700 transition" title="Edit Template">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                        <form method="POST" action="{{ route('admin.default-categories.destroy', $category) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDeleteDefaultCategory(this, '{{ $category->name }}')" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/50 transition" title="Hapus Template">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 text-center py-6">Belum ada kategori template pemasukan.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Template Pengeluaran (Expense) -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                                <h3 class="font-extrabold text-sm text-slate-900 dark:text-white">Template Pengeluaran</h3>
                            </div>
                            <span class="text-xs font-bold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/50 px-2 py-0.5 rounded-md">
                                {{ $defaultExpenseCategories->count() }} Kategori
                            </span>
                        </div>

                        <div class="space-y-2.5">
                            @forelse ($defaultExpenseCategories as $category)
                                <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3 group hover:border-[#4ABDAC]/40 transition">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-extrabold shrink-0 shadow-xs" style="background-color: {{ $category->color }}">
                                            <span class="uppercase">{{ substr($category->name, 0, 1) }}</span>
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $category->name }}</h4>
                                            <div class="flex items-center gap-2 text-[10px] text-slate-400">
                                                <span>Warna: <code class="font-mono">{{ $category->color }}</code></span>
                                                <span>&bull;</span>
                                                <span>Ikon: {{ $category->icon ?: 'tag' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-1 shrink-0">
                                        <button type="button" onclick="openEditDefaultCategoryModal({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ $category->type }}', '{{ $category->color }}', '{{ $category->icon }}')" class="p-1.5 rounded-lg text-slate-500 hover:text-slate-800 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-slate-700 transition" title="Edit Template">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                        <form method="POST" action="{{ route('admin.default-categories.destroy', $category) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDeleteDefaultCategory(this, '{{ $category->name }}')" class="p-1.5 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/50 transition" title="Hapus Template">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 text-center py-6">Belum ada kategori template pengeluaran.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            <!-- ======================================================== -->
            <!-- 5. MONITORING AI CHATBOT ("CATA") & SISTEM                -->
            <!-- ======================================================== -->
            <section id="section-monitoring" class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base sm:text-lg font-extrabold font-heading text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            5. Monitoring AI Chatbot ("Cata") & Sistem
                        </h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Status koneksi API Router LLM, pantauan kapasitas storage bukti foto, dan log sistem.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Monitor 1: Status Koneksi AI "Cata" -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-extrabold text-sm text-slate-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#4ABDAC]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Koneksi AI Chatbot ("Cata")
                                </h3>
                                <span id="aiStatusBadge" class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold {{ $aiStatus['online'] ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800' : 'bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $aiStatus['online'] ? 'bg-emerald-500 animate-pulse' : 'bg-rose-500' }}"></span>
                                    <span id="aiStatusText">{{ $aiStatus['online'] ? 'Online / Siap' : 'Terputus / Error' }}</span>
                                </span>
                            </div>

                            <div class="space-y-2 text-xs bg-slate-50 dark:bg-slate-800/60 p-3 rounded-xl border border-slate-100 dark:border-slate-800">
                                <div class="flex justify-between text-slate-500">
                                    <span>Model LLM:</span>
                                    <span class="font-mono font-semibold text-slate-800 dark:text-slate-200">{{ $aiStatus['model'] }}</span>
                                </div>
                                <div class="flex justify-between text-slate-500">
                                    <span>Latensi Ping:</span>
                                    <span id="aiLatencyDisplay" class="font-mono font-semibold text-slate-800 dark:text-slate-200">
                                        {{ $aiStatus['latency_ms'] !== null ? $aiStatus['latency_ms'] . ' ms' : '-' }}
                                    </span>
                                </div>
                                <div class="flex justify-between text-slate-500">
                                    <span>Provider:</span>
                                    <span class="font-semibold text-slate-800 dark:text-slate-200">Griphub Router</span>
                                </div>
                                <div class="pt-1.5 border-t border-slate-200/60 dark:border-slate-700/60 text-[11px] text-slate-400 truncate" title="{{ $aiStatus['message'] }}">
                                    {{ $aiStatus['message'] }}
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="pingAiChatbot()" class="w-full py-2.5 px-3 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-[#4ABDAC] hover:text-white text-slate-700 dark:text-slate-200 text-xs font-bold transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <span>Periksa Ulang Koneksi AI</span>
                        </button>
                    </div>

                    <!-- Monitor 2: Pemakaian Storage Struk -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-extrabold text-sm text-slate-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2 1 3 3 3h10c2 0 3-1 3-3V7c0-2-1-3-3-3H7C5 4 4 5 4 7z"/>
                                    </svg>
                                    Storage Bukti Foto Transaksi
                                </h3>
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-purple-50 dark:bg-purple-950/40 text-purple-600 dark:text-purple-400 border border-purple-200 dark:border-purple-800">
                                    Kuota: 500 MB
                                </span>
                            </div>

                            <div class="space-y-3 bg-slate-50 dark:bg-slate-800/60 p-3 rounded-xl border border-slate-100 dark:border-slate-800 text-xs">
                                <div class="flex justify-between items-baseline">
                                    <span class="text-slate-500">Ukuran Terpakai:</span>
                                    <span class="font-extrabold text-base text-slate-900 dark:text-white">{{ $storageStats['formatted'] }}</span>
                                </div>
                                <div class="w-full h-2.5 bg-slate-200 dark:bg-slate-700 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-purple-500 to-indigo-500 rounded-full" style="width: {{ max(3, $storageStats['percentage']) }}%"></div>
                                </div>
                                <div class="flex justify-between text-[11px] text-slate-400">
                                    <span>{{ $storageStats['count'] }} berkas tersimpan</span>
                                    <span>{{ $storageStats['percentage'] }}% digunakan</span>
                                </div>
                                <div class="pt-1.5 border-t border-slate-200/60 dark:border-slate-700/60 text-[10px] text-slate-400 truncate">
                                    Direktori: <code class="font-mono text-slate-600 dark:text-slate-300">{{ $storageStats['directory'] }}</code>
                                </div>
                            </div>
                        </div>

                        <div class="p-2.5 rounded-xl bg-emerald-50/70 dark:bg-emerald-950/30 border border-emerald-100 dark:border-emerald-900/50 flex items-center gap-2 text-xs text-emerald-700 dark:text-emerald-400">
                            <svg class="w-4 h-4 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span>Kapasitas penyimpanan server dalam kondisi sangat aman.</span>
                        </div>
                    </div>

                    <!-- Monitor 3: Log Aktivitas & Error Sistem -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between space-y-4">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="font-extrabold text-sm text-slate-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Log Sistem Terbaru
                                </h3>
                                <form method="POST" action="{{ route('admin.monitoring.clear-log') }}" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin mengosongkan file log sistem?')" class="text-[11px] font-bold text-rose-600 dark:text-rose-400 hover:underline">
                                        Bersihkan Log
                                    </button>
                                </form>
                            </div>

                            <!-- Log Viewer Window -->
                            <div class="h-44 overflow-y-auto custom-scrollbar p-3 rounded-xl bg-slate-900 text-slate-200 font-mono text-[11px] space-y-2 border border-slate-800">
                                @forelse ($systemLogs as $logItem)
                                    <div class="leading-tight border-b border-slate-800/80 pb-1.5 last:border-0 last:pb-0">
                                        <div class="flex items-center gap-1.5 text-[10px]">
                                            <span class="text-slate-500">{{ $logItem['timestamp'] }}</span>
                                            @if ($logItem['level'] === 'ERROR')
                                                <span class="px-1 rounded bg-rose-500/20 text-rose-400 font-bold">ERR</span>
                                            @elseif ($logItem['level'] === 'WARNING')
                                                <span class="px-1 rounded bg-amber-500/20 text-amber-400 font-bold">WARN</span>
                                            @else
                                                <span class="px-1 rounded bg-sky-500/20 text-sky-400 font-bold">INFO</span>
                                            @endif
                                        </div>
                                        <p class="text-slate-300 mt-0.5 line-clamp-2 break-all" title="{{ $logItem['message'] }}">
                                            {{ $logItem['message'] }}
                                        </p>
                                    </div>
                                @empty
                                    <div class="text-center py-10 text-slate-500 text-xs">
                                        Belum ada error/log sistem yang tercatat. Sistem beroperasi lancar.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="text-[11px] text-slate-400 flex items-center justify-between">
                            <span>Sumber: <code>laravel.log</code></span>
                            <span class="text-emerald-500 font-semibold">&bull; Live Monitoring</span>
                        </div>
                    </div>
                </div>

                <!-- Recent Registrations & Transactions Quick Feed -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                    <!-- Recent Signups -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs">
                        <h4 class="font-extrabold text-xs text-slate-400 uppercase tracking-wider mb-3">5 Pendaftaran Pengguna Terkini</h4>
                        <div class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($recentUsers as $ru)
                                <div class="py-2.5 flex items-center justify-between text-xs">
                                    <div class="flex items-center gap-2.5 min-w-0">
                                        <div class="w-7 h-7 rounded-full bg-[#4ABDAC]/20 text-[#4ABDAC] font-bold text-[10px] flex items-center justify-center shrink-0">
                                            {{ strtoupper(substr($ru->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="font-bold text-slate-900 dark:text-white truncate">{{ $ru->name }}</p>
                                            <p class="text-[10px] text-slate-400 truncate">{{ $ru->email }}</p>
                                        </div>
                                    </div>
                                    <span class="text-[10px] text-slate-400 shrink-0">{{ $ru->created_at ? $ru->created_at->diffForHumans() : '' }}</span>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 py-3 text-center">Belum ada user terdaftar.</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Recent Transactions -->
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-5 border border-slate-200 dark:border-slate-800 shadow-xs">
                        <h4 class="font-extrabold text-xs text-slate-400 uppercase tracking-wider mb-3">5 Transaksi Terakhir di Platform</h4>
                        <div class="divide-y divide-slate-100 dark:divide-slate-800">
                            @forelse ($recentTransactions as $rt)
                                <div class="py-2.5 flex items-center justify-between text-xs">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-1.5">
                                            <span class="font-bold text-slate-900 dark:text-white truncate">{{ $rt->description }}</span>
                                            <span class="text-[10px] px-1 py-0.2 rounded {{ $rt->type === 'income' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300' : 'bg-rose-100 text-rose-700 dark:bg-rose-950 dark:text-rose-300' }}">
                                                {{ $rt->category?->name ?? 'Umum' }}
                                            </span>
                                        </div>
                                        <p class="text-[10px] text-slate-400 truncate">Oleh: {{ $rt->user?->name ?? 'Pengguna' }}</p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <div class="font-extrabold {{ $rt->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-900 dark:text-white' }}">
                                            {{ $rt->type === 'income' ? '+' : '-' }}Rp{{ number_format((float) $rt->amount, 0, ',', '.') }}
                                        </div>
                                        <div class="text-[10px] text-slate-400">{{ $rt->created_at ? $rt->created_at->diffForHumans() : '' }}</div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-slate-400 py-3 text-center">Belum ada transaksi tercatat.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL TAMBAH TEMPLATE KATEGORI DEFAULT                    -->
    <!-- ======================================================== -->
    <div id="createTemplateModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full p-6 border border-slate-200 dark:border-slate-800 shadow-xl space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-extrabold text-base text-slate-900 dark:text-white">Tambah Template Kategori Bawaan</h3>
                <button type="button" onclick="closeCreateDefaultCategoryModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-lg font-bold">&times;</button>
            </div>

            <form method="POST" action="{{ route('admin.default-categories.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Kategori</label>
                    <input type="text" name="name" required placeholder="Contoh: Belanja Bulanan" class="w-full px-3 py-2 rounded-xl text-xs sm:text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#4ABDAC]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jenis Kategori</label>
                    <select name="type" required class="w-full px-3 py-2 rounded-xl text-xs sm:text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#4ABDAC]">
                        <option value="expense">Pengeluaran (Expense)</option>
                        <option value="income">Pemasukan (Income)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Warna Label</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="color" value="#10b981" class="w-10 h-10 rounded-xl cursor-pointer border border-slate-200 dark:border-slate-700 p-0.5 bg-transparent">
                        <span class="text-xs text-slate-400">Pilih warna aksen kategori untuk grafik dan kartu.</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Ikon Kategori</label>
                    <select name="icon" class="w-full px-3 py-2 rounded-xl text-xs sm:text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#4ABDAC]">
                        <option value="tag">Tag (Standar)</option>
                        <option value="wallet">Dompet / Gaji (Wallet)</option>
                        <option value="gift">Hadiah / Bonus (Gift)</option>
                        <option value="trending-up">Investasi (Trending Up)</option>
                        <option value="utensils">Makanan & Minuman (Utensils)</option>
                        <option value="car">Transportasi & Bensin (Car)</option>
                        <option value="shopping-bag">Belanja & Hiburan (Shopping Bag)</option>
                        <option value="zap">Listrik & Tagihan (Zap)</option>
                        <option value="coffee">Kafe & Nongkrong (Coffee)</option>
                        <option value="home">Rumah Tangga (Home)</option>
                        <option value="heart">Kesehatan (Heart)</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeCreateDefaultCategoryModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-[#4ABDAC] hover:bg-[#3ca092] text-white text-xs font-bold shadow-md transition">
                        Simpan Template
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- MODAL EDIT TEMPLATE KATEGORI DEFAULT                      -->
    <!-- ======================================================== -->
    <div id="editTemplateModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-2xl max-w-md w-full p-6 border border-slate-200 dark:border-slate-800 shadow-xl space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="font-extrabold text-base text-slate-900 dark:text-white">Edit Template Kategori Bawaan</h3>
                <button type="button" onclick="closeEditDefaultCategoryModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 text-lg font-bold">&times;</button>
            </div>

            <form id="editTemplateForm" method="POST" action="" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Nama Kategori</label>
                    <input type="text" id="editCategoryName" name="name" required class="w-full px-3 py-2 rounded-xl text-xs sm:text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#4ABDAC]">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Jenis Kategori</label>
                    <select id="editCategoryType" name="type" required class="w-full px-3 py-2 rounded-xl text-xs sm:text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#4ABDAC]">
                        <option value="expense">Pengeluaran (Expense)</option>
                        <option value="income">Pemasukan (Income)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Warna Label</label>
                    <div class="flex items-center gap-3">
                        <input type="color" id="editCategoryColor" name="color" class="w-10 h-10 rounded-xl cursor-pointer border border-slate-200 dark:border-slate-700 p-0.5 bg-transparent">
                        <span class="text-xs text-slate-400">Pilih warna aksen kategori.</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Ikon Kategori</label>
                    <select id="editCategoryIcon" name="icon" class="w-full px-3 py-2 rounded-xl text-xs sm:text-sm bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#4ABDAC]">
                        <option value="tag">Tag (Standar)</option>
                        <option value="wallet">Dompet / Gaji (Wallet)</option>
                        <option value="gift">Hadiah / Bonus (Gift)</option>
                        <option value="trending-up">Investasi (Trending Up)</option>
                        <option value="utensils">Makanan & Minuman (Utensils)</option>
                        <option value="car">Transportasi & Bensin (Car)</option>
                        <option value="shopping-bag">Belanja & Hiburan (Shopping Bag)</option>
                        <option value="zap">Listrik & Tagihan (Zap)</option>
                        <option value="coffee">Kafe & Nongkrong (Coffee)</option>
                        <option value="home">Rumah Tangga (Home)</option>
                        <option value="heart">Kesehatan (Heart)</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeEditDefaultCategoryModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 rounded-xl bg-[#4ABDAC] hover:bg-[#3ca092] text-white text-xs font-bold shadow-md transition">
                        Perbarui Template
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- JAVASCRIPT: THEME, SIDEBAR, CHARTS & SWEETALERT           -->
    <!-- ======================================================== -->
    <script>
        // 1. Theme Management
        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('catatuang_theme', isDark ? 'dark' : 'light');
            updateThemeIcons();
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

        // 2. Sidebar Drawer Handling
        const sidebarDrawer = document.getElementById('sidebarDrawer');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const sidebarOpenBtn = document.getElementById('sidebarOpenBtn');
        const headerBrandLogo = document.getElementById('headerBrandLogo');
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
            headerBrandLogo?.classList.remove('sm:flex');
            applyOpenLayout();
        }

        function closeSidebar() {
            if (!isSidebarOpen) return;
            isSidebarOpen = false;
            sidebarDrawer.classList.add('-translate-x-full');
            sidebarDrawer.setAttribute('aria-hidden', 'true');
            sidebarOpenBtn?.setAttribute('aria-expanded', 'false');
            headerBrandLogo?.classList.add('sm:flex');
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

        // 3. SweetAlert2 Actions for User Management
        function confirmSuspendUser(button, userName) {
            Swal.fire({
                title: 'Nonaktifkan Akun Pengguna?',
                text: `Akun "${userName}" akan ditangguhkan (disuspend) dan tidak dapat login ke sistem sampai diaktifkan kembali.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Nonaktifkan Akun',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        function confirmActivateUser(button, userName) {
            Swal.fire({
                title: 'Aktifkan Kembali Akun?',
                text: `Akun "${userName}" akan diaktifkan kembali dan dapat login ke aplikasi secara normal.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Aktifkan Akun',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        function confirmChangeRole(button, userName, targetRole) {
            Swal.fire({
                title: `Ubah Peran Pengguna?`,
                text: `Apakah Anda ingin mengubah peran akun "${userName}" menjadi ${targetRole}?`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Ubah Peran',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        function confirmDeleteUser(button, userName) {
            Swal.fire({
                title: 'Hapus Akun Pengguna Permanen?',
                text: `Akun "${userName}" beserta seluruh kategori dan riwayat transaksinya akan dihapus selamanya. Tindakan ini tidak dapat dibatalkan!`,
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Hapus Permanen',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        // 4. Modals for Default Category Templates
        function openCreateDefaultCategoryModal() {
            document.getElementById('createTemplateModal').classList.remove('hidden');
        }

        function closeCreateDefaultCategoryModal() {
            document.getElementById('createTemplateModal').classList.add('hidden');
        }

        function openEditDefaultCategoryModal(id, name, type, color, icon) {
            const form = document.getElementById('editTemplateForm');
            form.action = `/admin/default-categories/${id}`;
            document.getElementById('editCategoryName').value = name;
            document.getElementById('editCategoryType').value = type;
            document.getElementById('editCategoryColor').value = color || '#10b981';
            document.getElementById('editCategoryIcon').value = icon || 'tag';
            document.getElementById('editTemplateModal').classList.remove('hidden');
        }

        function closeEditDefaultCategoryModal() {
            document.getElementById('editTemplateModal').classList.add('hidden');
        }

        function confirmDeleteDefaultCategory(button, categoryName) {
            Swal.fire({
                title: 'Hapus Template Kategori?',
                text: `Template "${categoryName}" akan dihapus dari daftar kategori bawaan user baru. Kategori pengguna yang sudah ada tidak terpengaruh.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus Template',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }

        // 5. Live Ping AI Chatbot ("Cata")
        async function pingAiChatbot() {
            const pingBtn = document.getElementById('pingAiBtnText');
            const pingIcon = document.getElementById('pingAiBtnIcon');
            const statusBadge = document.getElementById('aiStatusBadge');
            const statusText = document.getElementById('aiStatusText');
            const latencyDisplay = document.getElementById('aiLatencyDisplay');

            if (pingBtn) pingBtn.innerText = 'Memeriksa...';
            if (pingIcon) pingIcon.classList.add('animate-spin');

            try {
                const response = await fetch('{{ route('admin.monitoring.check-ai') }}', { credentials: 'same-origin' });
                const data = await response.json();

                if (data.online) {
                    statusBadge.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800';
                    statusBadge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span><span>Online / Siap</span>`;
                    if (latencyDisplay) latencyDisplay.innerText = `${data.latency_ms} ms`;

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: `AI Chatbot Online (${data.latency_ms} ms)`,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    statusBadge.className = 'inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800';
                    statusBadge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span><span>Error / Terputus</span>`;
                    if (latencyDisplay) latencyDisplay.innerText = '-';

                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Koneksi AI Terputus',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 4000
                    });
                }
            } catch (err) {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Gagal mengecek status API AI',
                    showConfirmButton: false,
                    timer: 3000
                });
            } finally {
                if (pingBtn) pingBtn.innerText = 'Tes Koneksi AI';
                if (pingIcon) pingIcon.classList.remove('animate-spin');
            }
        }

        // ========================================================
        // 6. CHART.JS CONFIGURATION & SWITCHERS
        // ========================================================
        const userGrowthMonthlyLabels = @json($userGrowthMonthlyLabels);
        const userGrowthMonthlyData = @json($userGrowthMonthlyData);
        const userGrowthWeeklyLabels = @json($userGrowthWeeklyLabels);
        const userGrowthWeeklyData = @json($userGrowthWeeklyData);

        const txTrendMonthlyLabels = @json($txTrendMonthlyLabels);
        const txTrendMonthlyIncomeData = @json($txTrendMonthlyIncomeData);
        const txTrendMonthlyExpenseData = @json($txTrendMonthlyExpenseData);
        const txTrendDailyLabels = @json($txTrendDailyLabels);
        const txTrendDailyData = @json($txTrendDailyData);

        const isDark = document.documentElement.classList.contains('dark');
        const gridColor = isDark ? 'rgba(51, 65, 85, 0.4)' : 'rgba(226, 232, 240, 0.8)';
        const tickColor = isDark ? '#94a3b8' : '#64748b';

        // Chart 1: User Growth
        const userCtx = document.getElementById('userGrowthChart').getContext('2d');
        let userGrowthChart = new Chart(userCtx, {
            type: 'line',
            data: {
                labels: userGrowthMonthlyLabels,
                datasets: [{
                    label: 'Registrasi Baru',
                    data: userGrowthMonthlyData,
                    borderColor: '#4ABDAC',
                    backgroundColor: 'rgba(74, 189, 172, 0.15)',
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#4ABDAC',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: tickColor, font: { size: 10 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: {
                            precision: 0,
                            color: tickColor,
                            font: { size: 10 }
                        }
                    }
                }
            }
        });

        function switchUserGrowth(mode) {
            const btnM = document.getElementById('btnUserMonthly');
            const btnW = document.getElementById('btnUserWeekly');

            if (mode === 'monthly') {
                userGrowthChart.data.labels = userGrowthMonthlyLabels;
                userGrowthChart.data.datasets[0].data = userGrowthMonthlyData;
                btnM.className = 'px-2 py-1 rounded-md bg-white dark:bg-slate-700 text-slate-800 dark:text-white shadow-xs';
                btnW.className = 'px-2 py-1 rounded-md text-slate-500 hover:text-slate-800 dark:hover:text-white';
            } else {
                userGrowthChart.data.labels = userGrowthWeeklyLabels;
                userGrowthChart.data.datasets[0].data = userGrowthWeeklyData;
                btnW.className = 'px-2 py-1 rounded-md bg-white dark:bg-slate-700 text-slate-800 dark:text-white shadow-xs';
                btnM.className = 'px-2 py-1 rounded-md text-slate-500 hover:text-slate-800 dark:hover:text-white';
            }
            userGrowthChart.update();
        }

        // Chart 2: Transaction Activity Trend
        const txCtx = document.getElementById('txActivityChart').getContext('2d');
        let txActivityChart = new Chart(txCtx, {
            type: 'bar',
            data: {
                labels: txTrendMonthlyLabels,
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: txTrendMonthlyIncomeData,
                        backgroundColor: '#10b981',
                        borderRadius: 6
                    },
                    {
                        label: 'Pengeluaran',
                        data: txTrendMonthlyExpenseData,
                        backgroundColor: '#ef4444',
                        borderRadius: 6
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: tickColor,
                            font: { size: 10, weight: 'bold' },
                            boxWidth: 10
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: tickColor, font: { size: 10 } }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: gridColor },
                        ticks: {
                            precision: 0,
                            color: tickColor,
                            font: { size: 10 }
                        }
                    }
                }
            }
        });

        function switchTxTrend(mode) {
            const btnM = document.getElementById('btnTxMonthly');
            const btnD = document.getElementById('btnTxDaily');

            if (mode === 'monthly') {
                txActivityChart.config.type = 'bar';
                txActivityChart.data.labels = txTrendMonthlyLabels;
                txActivityChart.data.datasets = [
                    {
                        label: 'Pemasukan',
                        data: txTrendMonthlyIncomeData,
                        backgroundColor: '#10b981',
                        borderRadius: 6
                    },
                    {
                        label: 'Pengeluaran',
                        data: txTrendMonthlyExpenseData,
                        backgroundColor: '#ef4444',
                        borderRadius: 6
                    }
                ];
                btnM.className = 'px-2 py-1 rounded-md bg-white dark:bg-slate-700 text-slate-800 dark:text-white shadow-xs';
                btnD.className = 'px-2 py-1 rounded-md text-slate-500 hover:text-slate-800 dark:hover:text-white';
            } else {
                txActivityChart.config.type = 'line';
                txActivityChart.data.labels = txTrendDailyLabels;
                txActivityChart.data.datasets = [
                    {
                        label: 'Frekuensi Transaksi',
                        data: txTrendDailyData,
                        borderColor: '#0284c7',
                        backgroundColor: 'rgba(2, 132, 199, 0.15)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 2.5,
                        pointRadius: 2,
                        pointHoverRadius: 5
                    }
                ];
                btnD.className = 'px-2 py-1 rounded-md bg-white dark:bg-slate-700 text-slate-800 dark:text-white shadow-xs';
                btnM.className = 'px-2 py-1 rounded-md text-slate-500 hover:text-slate-800 dark:hover:text-white';
            }
            txActivityChart.update();
        }

        // Theme sync for Chart.js
        function updateChartsTheme(dark) {
            const newGrid = dark ? 'rgba(51, 65, 85, 0.4)' : 'rgba(226, 232, 240, 0.8)';
            const newTick = dark ? '#94a3b8' : '#64748b';

            if (userGrowthChart) {
                userGrowthChart.options.scales.x.ticks.color = newTick;
                userGrowthChart.options.scales.y.ticks.color = newTick;
                userGrowthChart.options.scales.y.grid.color = newGrid;
                userGrowthChart.update();
            }

            if (txActivityChart) {
                txActivityChart.options.scales.x.ticks.color = newTick;
                txActivityChart.options.scales.y.ticks.color = newTick;
                txActivityChart.options.scales.y.grid.color = newGrid;
                if (txActivityChart.options.plugins?.legend?.labels) {
                    txActivityChart.options.plugins.legend.labels.color = newTick;
                }
                txActivityChart.update();
            }
        }
    </script>
</body>
</html>
