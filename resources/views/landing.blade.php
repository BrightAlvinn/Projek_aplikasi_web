<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth bg-[#F8F9FB] dark:bg-slate-950 text-slate-800 dark:text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="CatatUang - Kelola Uang Makin Gampang. Aplikasi pencatatan dan arus kas modern.">
    <title>CATATUANG - Kelola Uang Makin Gampang</title>

    <!-- Theme Initialization Script -->
    <script>
        if (localStorage.getItem('catatuang_theme') === 'dark' || 
            (!localStorage.getItem('catatuang_theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Google Fonts: Kantumruy Pro & Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS Play CDN (agar langsung berwarna tanpa build jika Vite belum siap) -->
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
                        destructive: {
                            DEFAULT: '#FC4A1A',
                            hover: '#e03b0d',
                            light: '#fef0ec'
                        },
                        accent: {
                            DEFAULT: '#F7B733',
                            hover: '#e5a420',
                            light: '#fef9eb'
                        }
                    },
                    fontFamily: {
                        heading: ['Kantumruy Pro', 'sans-serif'],
                        sans: ['Manrope', 'sans-serif']
                    }
                }
            }
        }
    </script>

    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        .font-heading { font-family: 'Kantumruy Pro', sans-serif; }
        .btn-catat-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.75rem 1.5rem; border-radius: 0.875rem; font-weight: 700; font-size: 0.9375rem;
            background-color: #4ABDAC; color: #ffffff; border: 2px solid transparent;
            box-shadow: 0 4px 14px rgba(74, 189, 172, 0.3); transition: all 0.2s ease; cursor: pointer; text-decoration: none;
        }
        .btn-catat-primary:hover { background-color: #3ca092; transform: translateY(-1px); box-shadow: 0 6px 18px rgba(74, 189, 172, 0.4); }
        .btn-catat-outline {
            display: inline-flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.75rem 1.5rem; border-radius: 0.875rem; font-weight: 700; font-size: 0.9375rem;
            background-color: #ffffff; color: #4ABDAC; border: 2px solid #4ABDAC;
            box-shadow: 0 2px 8px rgba(74, 189, 172, 0.1); transition: all 0.2s ease; cursor: pointer; text-decoration: none;
        }
        .btn-catat-outline:hover { background-color: #4ABDAC; color: #ffffff; }
        .dark .btn-catat-outline { background-color: #131b2a; color: #4ABDAC; }
        .card-custom {
            background-color: #ffffff; border: 1px solid #DFDCE3;
            box-shadow: 0 4px 20px -2px rgba(100, 116, 139, 0.05); transition: all 0.2s ease;
        }
        .card-custom:hover { border-color: #4ABDAC; box-shadow: 0 8px 30px -4px rgba(74, 189, 172, 0.15); }
        .dark .card-custom { background-color: #131b2a; border-color: #1e293b; }
        .dark .card-custom:hover { border-color: #4ABDAC; }
    </style>
</head>
<body class="min-h-full bg-[#F8F9FB] dark:bg-slate-950 font-sans antialiased text-slate-800 dark:text-slate-200 selection:bg-[#4ABDAC]/25 selection:text-[#2e7e73] relative overflow-x-hidden transition-colors duration-300">

    <!-- Ambient Subtle Glow Backgrounds (Pendaran Warna Latar Belakang) -->
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden">
        <div class="absolute -top-40 left-1/4 w-[600px] h-[500px] bg-[#4ABDAC]/10 dark:bg-[#4ABDAC]/5 rounded-full blur-3xl"></div>
        <div class="absolute top-[35%] -left-36 w-[500px] h-[500px] bg-[#F7B733]/15 dark:bg-[#F7B733]/5 rounded-full blur-3xl"></div>
        <div class="absolute top-[20%] -right-36 w-[600px] h-[600px] bg-[#4ABDAC]/10 dark:bg-[#4ABDAC]/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-1/4 w-[500px] h-[400px] bg-[#FC4A1A]/8 dark:bg-[#FC4A1A]/5 rounded-full blur-3xl"></div>
    </div>

    <!-- TOP NAVIGATION BAR -->
    <header class="relative z-30 w-full border-b border-[#DFDCE3] dark:border-slate-800 bg-white/90 dark:bg-slate-900/90 backdrop-blur-xl transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl bg-[#4ABDAC] p-2 flex items-center justify-center shadow-md shadow-[#4ABDAC]/25 group-hover:scale-105 transition-transform duration-300">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-1.5">
                        <span class="text-2xl font-bold font-heading text-[#4ABDAC] tracking-tight">CATATUANG</span>
                    </div>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 font-semibold tracking-tight hidden sm:block">Kelola Uang Makin Gampang</p>
                </div>
            </a>

            <!-- Nav Menu Links -->
            <nav class="flex items-center gap-3 sm:gap-5">
                <a href="#fitur" class="text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-[#4ABDAC] transition-colors">Fitur</a>
                <a href="#kalkulator" class="text-sm font-bold text-slate-600 dark:text-slate-300 hover:text-[#4ABDAC] transition-colors hidden sm:inline-block">Kalkulator</a>

                <!-- Theme Toggle Button -->
                <button type="button" onclick="toggleTheme()" class="p-2 rounded-xl bg-[#F4F3F6] dark:bg-slate-800 border border-[#DFDCE3] dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:text-[#4ABDAC] transition" title="Ganti Mode Gelap/Terang">
                    <svg class="theme-icon-sun hidden w-5 h-5 text-[#F7B733]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <svg class="theme-icon-moon w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <button type="button" onclick="openAuthDrawer('login')" class="btn-catat-outline px-4 sm:px-6 py-2 text-xs sm:text-sm">
                    Masuk
                </button>
                <button type="button" onclick="openAuthDrawer('register')" class="btn-catat-primary px-4 sm:px-6 py-2 text-xs sm:text-sm">
                    Catat Sekarang
                </button>
            </nav>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative z-10 w-full min-h-[calc(100vh-80px)] flex items-center py-12 lg:py-20 border-b border-[#DFDCE3] dark:border-slate-800 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                <!-- Left Column: Headline & CTA -->
                <div class="lg:col-span-7">
                    <!-- Brand Pill Tag -->
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#eaf7f5] dark:bg-[#4ABDAC]/15 border border-[#4ABDAC]/30 text-[#2e7e73] dark:text-[#4ABDAC] text-xs font-bold mb-6">
                        <span class="w-2 h-2 rounded-full bg-[#4ABDAC] animate-pulse"></span>
                        CATATUANG / Kelola Uang Makin Gampang
                    </div>

                    <!-- Heading 1 (Primary Color #4ABDAC) -->
                    <h1 class="text-4xl sm:text-5xl lg:text-[48px] font-bold font-heading text-[#4ABDAC] leading-[1.15] mb-4">
                        Kendalikan Keuangan <br class="hidden sm:inline">
                        <span class="text-slate-800 dark:text-white">Anda Mulai Hari Ini</span>
                    </h1>

                    <!-- Heading 2 Subtitle (Coral #FC4A1A accent) -->
                    <h2 class="text-xl sm:text-2xl lg:text-[28px] font-semibold font-heading text-[#FC4A1A] mb-6">
                        Kelola Uang Makin Gampang Bersama CatatUang
                    </h2>

                    <!-- Body Description -->
                    <p class="text-slate-600 dark:text-slate-300 text-base sm:text-lg leading-relaxed mb-8 max-w-xl">
                        Catat pemasukan dan pengeluaran harian dengan cepat, visualisasikan grafik pergerakan uang, dan capai kebebasan finansial tanpa ribet.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap items-center gap-4 mb-10">
                        <button type="button" onclick="openAuthDrawer('register')" class="btn-catat-primary text-base px-8 py-3.5 shadow-lg shadow-[#4ABDAC]/25">
                            <span>Daftar Gratis</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </button>
                        <button type="button" onclick="openAuthDrawer('login')" class="btn-catat-outline text-base px-7 py-3.5">
                            <span>Masuk ke Akun Anda</span>
                        </button>
                    </div>

                    <!-- Trust Highlights with Palette Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-6 border-t border-[#DFDCE3] dark:border-slate-800 text-xs font-semibold text-slate-600 dark:text-slate-400">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-[#4ABDAC]/20 text-[#4ABDAC] flex items-center justify-center font-bold">✓</span>
                            <span>100% Gratis & Bebas Biaya</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-[#F7B733]/20 text-[#d89300] dark:text-[#F7B733] flex items-center justify-center font-bold">★</span>
                            <span>Visualisasi Arus Kas Real-time</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-[#FC4A1A]/20 text-[#FC4A1A] flex items-center justify-center font-bold">🔒</span>
                            <span>Data Aman & Terenkripsi</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive App Showcase Card -->
                <div class="lg:col-span-5 relative">
                    <!-- Glow Backdrop -->
                    <div class="absolute -inset-4 bg-[#4ABDAC]/15 rounded-3xl blur-2xl pointer-events-none"></div>

                    <!-- Mockup Card -->
                    <div class="relative bg-white dark:bg-slate-900 border-2 border-[#DFDCE3] dark:border-slate-800 rounded-3xl p-5 sm:p-7 shadow-2xl transition-colors duration-300">
                        <!-- Card Header Mockup -->
                        <div class="flex items-center justify-between pb-4 border-b border-[#DFDCE3] dark:border-slate-800 mb-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-[#4ABDAC] text-white flex items-center justify-center font-bold font-heading text-sm">
                                    C
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold font-heading text-slate-800 dark:text-white">CatatUang Dashboard</h4>
                                    <p class="text-[10px] text-slate-400 dark:text-slate-500 font-medium">Ringkasan Bulan Ini</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-[#eaf7f5] dark:bg-[#4ABDAC]/20 text-[#2e7e73] dark:text-[#4ABDAC] border border-[#4ABDAC]/30">
                                Aktif
                            </span>
                        </div>

                        <!-- 2 Quick Metrics -->
                        <div class="grid grid-cols-2 gap-3 mb-5">
                            <div class="p-3.5 rounded-2xl bg-[#F8F9FB] dark:bg-slate-800/80 border border-[#DFDCE3] dark:border-slate-700">
                                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400">Pemasukan</span>
                                <p class="text-base sm:text-lg font-black text-[#4ABDAC] mt-0.5">+ Rp 14.500.000</p>
                                <span class="text-[9px] font-bold text-[#2e7e73] dark:text-[#4ABDAC] bg-[#4ABDAC]/15 px-1.5 py-0.5 rounded">Inflow</span>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-[#F8F9FB] dark:bg-slate-800/80 border border-[#DFDCE3] dark:border-slate-700">
                                <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400">Pengeluaran</span>
                                <p class="text-base sm:text-lg font-black text-[#FC4A1A] mt-0.5">- Rp 5.250.000</p>
                                <span class="text-[9px] font-bold text-[#FC4A1A] bg-[#FC4A1A]/15 px-1.5 py-0.5 rounded">Outflow</span>
                            </div>
                        </div>

                        <!-- Visual Progress Bars -->
                        <div class="p-4 rounded-2xl bg-[#F8F9FB] dark:bg-slate-800/80 border border-[#DFDCE3] dark:border-slate-700 mb-5">
                            <div class="flex items-center justify-between text-xs font-bold mb-2">
                                <span class="text-slate-600 dark:text-slate-300">Alokasi Anggaran Bulanan</span>
                                <span class="text-[#4ABDAC]">64% Sisa Saldo</span>
                            </div>
                            <div class="w-full bg-[#DFDCE3] dark:bg-slate-700 h-3.5 rounded-full overflow-hidden flex">
                                <div class="bg-[#4ABDAC] h-full" style="width: 50%" title="Kebutuhan (50%)"></div>
                                <div class="bg-[#F7B733] h-full" style="width: 25%" title="Tabungan (25%)"></div>
                                <div class="bg-[#FC4A1A] h-full" style="width: 25%" title="Keinginan (25%)"></div>
                            </div>
                            <div class="flex items-center justify-between text-[10px] text-slate-500 dark:text-slate-400 font-semibold mt-2">
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#4ABDAC]"></span> Kebutuhan</span>
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#F7B733]"></span> Tabungan</span>
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#FC4A1A]"></span> Keinginan</span>
                            </div>
                        </div>

                        <!-- Mini Transactions Sample -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-white dark:bg-slate-800 border border-[#DFDCE3] dark:border-slate-700 text-xs">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-[#4ABDAC]/15 text-[#4ABDAC] flex items-center justify-center font-bold">↓</div>
                                    <div>
                                        <p class="font-bold text-slate-800 dark:text-slate-200">Gaji Bulanan</p>
                                        <span class="text-[10px] text-slate-400">Pekerjaan Utama</span>
                                    </div>
                                </div>
                                <span class="font-bold text-[#4ABDAC]">+ Rp 12.000.000</span>
                            </div>

                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-white dark:bg-slate-800 border border-[#DFDCE3] dark:border-slate-700 text-xs">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded-lg bg-[#FC4A1A]/15 text-[#FC4A1A] flex items-center justify-center font-bold">↑</div>
                                    <div>
                                        <p class="font-bold text-slate-800 dark:text-slate-200">Belanja Bulanan</p>
                                        <span class="text-[10px] text-slate-400">Supermarket</span>
                                    </div>
                                </div>
                                <span class="font-bold text-[#FC4A1A]">- Rp 1.450.000</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION FITUR UNGGULAN -->
    <section id="fitur" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="px-3.5 py-1 rounded-full bg-[#eaf7f5] dark:bg-[#4ABDAC]/15 text-[#2e7e73] dark:text-[#4ABDAC] text-xs font-bold uppercase tracking-wider border border-[#4ABDAC]/30">
                Fitur Unggulan
            </span>
            <h2 class="text-3xl sm:text-4xl font-bold font-heading text-[#4ABDAC] mt-4">
                Didesain Khusus untuk Efisiensi & Kontrol Finansial
            </h2>
            <p class="text-slate-600 dark:text-slate-300 text-base mt-3 font-normal">
                Nikmati kemudahan mencatat dan menganalisis setiap transaksi dalam satu aplikasi modern.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- 1. Pencatatan Instan -->
            <div class="p-7 rounded-3xl card-custom">
                <div class="w-12 h-12 rounded-2xl bg-[#4ABDAC]/15 text-[#4ABDAC] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                </div>
                <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white mb-2">Pencatatan Instan 5 Detik</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">Catat pengeluaran dan pemasukan dengan cepat lengkap dengan kategori, nominal, dan tanggal transaksi.</p>
            </div>

            <!-- 2. Grafik Tren -->
            <div class="p-7 rounded-3xl card-custom">
                <div class="w-12 h-12 rounded-2xl bg-[#FC4A1A]/15 text-[#FC4A1A] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                </div>
                <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white mb-2">Grafik Tren Arus Kas</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">Pantau pertumbuhan tabungan dan rasio pemasukan vs pengeluaran Anda dengan visualisasi grafik interaktif.</p>
            </div>

            <!-- 3. Kategori Berwarna -->
            <div class="p-7 rounded-3xl card-custom">
                <div class="w-12 h-12 rounded-2xl bg-[#F7B733]/20 text-[#c78600] dark:text-[#F7B733] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white mb-2">Kategori Kustom & Berwarna</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">Kelompokkan transaksi sesuka hati dengan pilihan palet warna dan ikon yang representatif.</p>
            </div>

            <!-- 4. Laporan & Filter -->
            <div class="p-7 rounded-3xl card-custom">
                <div class="w-12 h-12 rounded-2xl bg-[#4ABDAC]/15 text-[#4ABDAC] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white mb-2">Laporan & Filter Periode</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">Filter transaksi berdasarkan rentang tanggal, kategori, atau tipe untuk evaluasi anggaran berkala.</p>
            </div>

            <!-- 5. Ekspor CSV -->
            <div class="p-7 rounded-3xl card-custom">
                <div class="w-12 h-12 rounded-2xl bg-[#FC4A1A]/15 text-[#FC4A1A] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </div>
                <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white mb-2">Ekspor CSV Spreadsheet</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">Unduh seluruh riwayat pembukuan ke file format CSV untuk dibuka di Microsoft Excel atau Google Sheets.</p>
            </div>

            <!-- 6. Privasi Aman -->
            <div class="p-7 rounded-3xl card-custom">
                <div class="w-12 h-12 rounded-2xl bg-[#F7B733]/20 text-[#c78600] dark:text-[#F7B733] flex items-center justify-center mb-5">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="text-lg font-bold font-heading text-slate-900 dark:text-white mb-2">100% Privasi & Data Lokal</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed">Data Anda tersimpan di server database lokal Anda sendiri, tanpa pelacak atau iklan pihak ketiga.</p>
            </div>
        </div>
    </section>

    <!-- SECTION KALKULATOR ANGGARAN 50/30/20 -->
    <section id="kalkulator" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="p-8 sm:p-12 rounded-3xl bg-white dark:bg-slate-900 border border-[#DFDCE3] dark:border-slate-800 relative overflow-hidden shadow-xl transition-colors duration-300">
            <div class="max-w-3xl mx-auto text-center mb-8">
                <span class="px-3.5 py-1 rounded-full bg-[#fef9eb] dark:bg-[#F7B733]/15 text-[#b87b00] dark:text-[#F7B733] text-xs font-bold uppercase tracking-wider border border-[#F7B733]/40">
                    Kalkulator Interaktif
                </span>
                <h2 class="text-3xl sm:text-4xl font-bold font-heading text-[#4ABDAC] mt-4">
                    Kalkulator Aturan Anggaran 50 / 30 / 20
                </h2>
                <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base mt-2 font-normal">
                    Ketahui alokasi gaji ideal Anda: 50% Kebutuhan, 30% Keinginan, dan 20% Tabungan / Investasi.
                </p>
            </div>

            <div class="max-w-xl mx-auto space-y-6">
                <div>
                    <label for="incomeInput" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Pemasukan Bulanan Anda (Rp)
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#4ABDAC] font-bold text-base">
                            Rp
                        </span>
                        <input 
                            type="number" 
                            id="incomeInput" 
                            value="10000000" 
                            step="500000" 
                            min="100000"
                            class="w-full pl-14 pr-4 py-3 rounded-2xl bg-[#F8F9FB] dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 text-slate-900 dark:text-white font-bold text-lg focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition-all"
                        >
                    </div>
                </div>

                <!-- Preset Pills -->
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Contoh:</span>
                    <button type="button" class="preset-btn px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-[#4ABDAC]/10 text-slate-700 dark:text-slate-300 text-xs font-bold transition" data-amount="5000000">Rp 5 Juta</button>
                    <button type="button" class="preset-btn px-3 py-1.5 rounded-xl bg-[#4ABDAC] text-white text-xs font-bold transition shadow-sm" data-amount="10000000">Rp 10 Juta</button>
                    <button type="button" class="preset-btn px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-[#4ABDAC]/10 text-slate-700 dark:text-slate-300 text-xs font-bold transition" data-amount="20000000">Rp 20 Juta</button>
                    <button type="button" class="preset-btn px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-[#4ABDAC]/10 text-slate-700 dark:text-slate-300 text-xs font-bold transition" data-amount="35000000">Rp 35 Juta</button>
                </div>

                <!-- 3 Alokasi Cards Berwarna -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-3">
                    <div class="p-4 rounded-2xl bg-[#eaf7f5] dark:bg-[#4ABDAC]/15 border border-[#4ABDAC]/30">
                        <span class="text-xs font-bold text-[#2e7e73] dark:text-[#4ABDAC]">50% Kebutuhan</span>
                        <p id="needsResult" class="text-lg font-black text-[#4ABDAC] mt-1">Rp 5.000.000</p>
                        <p class="text-[11px] text-slate-600 dark:text-slate-400 mt-1">Makanan, rumah, listrik.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-[#fef0ec] dark:bg-[#FC4A1A]/15 border border-[#FC4A1A]/30">
                        <span class="text-xs font-bold text-[#FC4A1A]">30% Keinginan</span>
                        <p id="wantsResult" class="text-lg font-black text-[#FC4A1A] mt-1">Rp 3.000.000</p>
                        <p class="text-[11px] text-slate-600 dark:text-slate-400 mt-1">Hiburan, belanja, hobi.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-[#fef9eb] dark:bg-[#F7B733]/15 border border-[#F7B733]/40">
                        <span class="text-xs font-bold text-[#b87b00] dark:text-[#F7B733]">20% Tabungan</span>
                        <p id="savingsResult" class="text-lg font-black text-[#d89300] dark:text-[#F7B733] mt-1">Rp 2.000.000</p>
                        <p class="text-[11px] text-slate-600 dark:text-slate-400 mt-1">Dana darurat & investasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SLIDE-OVER AUTH DRAWER (MODAL MASUK / DAFTAR) -->
    <div id="auth-drawer-overlay" 
         onclick="closeAuthDrawer()" 
         class="opacity-0 pointer-events-none fixed inset-0 z-50 bg-slate-900/60 dark:bg-black/75 backdrop-blur-sm transition-opacity duration-300">
    </div>

    <aside id="auth-drawer" 
           class="translate-x-full fixed inset-y-0 right-0 z-50 w-full sm:w-[460px] md:w-[480px] bg-white dark:bg-slate-900 border-l border-[#DFDCE3] dark:border-slate-800 shadow-2xl transition-transform duration-500 ease-out flex flex-col justify-between overflow-y-auto">
        <div class="p-6 sm:p-8">
            <!-- Header with Close Button -->
            <div class="flex items-center justify-between pb-6 border-b border-[#DFDCE3] dark:border-slate-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-[#4ABDAC] flex items-center justify-center text-white font-bold font-heading">
                        C
                    </div>
                    <div>
                        <span class="text-base font-bold font-heading text-[#4ABDAC] tracking-tight">CATATUANG</span>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500">Kelola Uang Makin Gampang</p>
                    </div>
                </div>
                <button type="button" 
                        onclick="closeAuthDrawer()" 
                        class="p-2 rounded-xl text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-[#F4F3F6] dark:hover:bg-slate-800 transition-colors" 
                        title="Tutup">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- LOGIN BOX -->
            <div id="login-box" class="block pt-6">
                <div class="mb-5 pr-4">
                    <h2 class="text-2xl font-bold font-heading text-[#4ABDAC] tracking-tight">Masuk ke Akun Anda</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Masukkan kredensial Anda untuk melanjutkan ke dashboard CatatUang.</p>
                </div>

                <form action="{{ Route::has('login.post') ? route('login.post') : '#' }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label for="login-email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">Email / Username</label>
                        <input 
                            type="text" 
                            name="email" 
                            id="login-email" 
                            required 
                            placeholder="nama@email.com"
                            class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 text-slate-800 dark:text-white text-sm focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition-all"
                        >
                    </div>

                    <div>
                        <label for="login-password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1.5">Kata Sandi</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="login-password" 
                            required 
                            placeholder="Kata Sandi Anda"
                            class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 text-slate-800 dark:text-white text-sm focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition-all"
                        >
                    </div>

                    <button type="submit" class="btn-catat-primary w-full text-center">
                        Masuk Sekarang
                    </button>
                </form>

                <div class="mt-6 text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                    <span>Belum punya akun?</span>
                    <button type="button" onclick="switchToRegister()" class="font-bold text-[#4ABDAC] hover:underline ml-1">
                        Daftar Sekarang
                    </button>
                </div>
            </div>

            <!-- REGISTER BOX -->
            <div id="register-box" class="hidden pt-6">
                <div class="mb-4 pr-4">
                    <h2 class="text-2xl font-bold font-heading text-[#FC4A1A] tracking-tight">Daftar Akun Baru</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Buat akun CatatUang untuk mulai mencatat keuangan Anda.</p>
                </div>

                <form action="{{ Route::has('register.post') ? route('register.post') : '#' }}" method="POST" class="space-y-3.5">
                    @csrf
                    <div>
                        <label for="reg-name" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">Nama Lengkap</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="reg-name" 
                            required 
                            placeholder="Nama Lengkap Anda"
                            class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 text-slate-800 dark:text-white text-sm focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition-all"
                        >
                    </div>

                    <div>
                        <label for="reg-email" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="reg-email" 
                            required 
                            placeholder="nama@email.com"
                            class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 text-slate-800 dark:text-white text-sm focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition-all"
                        >
                    </div>

                    <div>
                        <label for="reg-password" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">Kata Sandi</label>
                        <input 
                            type="password" 
                            name="password" 
                            id="reg-password" 
                            required 
                            placeholder="Minimal 6 karakter"
                            class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 text-slate-800 dark:text-white text-sm focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition-all"
                        >
                    </div>

                    <div>
                        <label for="reg-password-confirm" class="block text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-1">Konfirmasi Kata Sandi</label>
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="reg-password-confirm" 
                            required 
                            placeholder="Ulangi kata sandi"
                            class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-950 border border-[#DFDCE3] dark:border-slate-700 text-slate-800 dark:text-white text-sm focus:outline-none focus:border-[#4ABDAC] focus:ring-2 focus:ring-[#4ABDAC]/20 transition-all"
                        >
                    </div>

                    <button type="submit" class="btn-catat-primary w-full mt-2 text-center">
                        Daftar Akun Baru
                    </button>
                </form>

                <div class="mt-5 text-center text-xs text-slate-500 dark:text-slate-400 font-medium">
                    <span>Sudah punya akun?</span>
                    <button type="button" onclick="switchToLogin()" class="font-bold text-[#4ABDAC] hover:underline ml-1">
                        Masuk di sini
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6 border-t border-[#DFDCE3] dark:border-slate-800 text-center bg-[#F8F9FB] dark:bg-slate-950">
            <p class="text-[11px] text-slate-500 dark:text-slate-400 leading-relaxed font-medium">
                Dilindungi oleh standar keamanan data CatatUang.
            </p>
        </div>
    </aside>

    <!-- FOOTER -->
    <footer class="border-t border-[#DFDCE3] dark:border-slate-800 bg-white dark:bg-slate-950 py-12 relative z-10 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-[#4ABDAC] flex items-center justify-center text-white font-bold font-heading text-sm">
                    C
                </div>
                <div>
                    <span class="text-base font-bold font-heading text-[#4ABDAC] tracking-tight">CATATUANG</span>
                    <span class="text-xs text-slate-500 dark:text-slate-400 ml-2 font-medium">• Kelola Uang Makin Gampang</span>
                </div>
            </div>

            <div class="flex items-center gap-6 text-xs font-bold text-slate-600 dark:text-slate-400">
                <a href="#fitur" class="hover:text-[#4ABDAC] transition">Fitur</a>
                <a href="#kalkulator" class="hover:text-[#4ABDAC] transition">Kalkulator</a>
                <button type="button" onclick="switchToLogin()" class="hover:text-[#4ABDAC] transition">Masuk</button>
                <button type="button" onclick="switchToRegister()" class="hover:text-[#4ABDAC] transition">Daftar</button>
            </div>

            <p class="text-xs text-slate-400">&copy; {{ date('Y') }} CatatUang. Hak Cipta Dilindungi.</p>
        </div>
    </footer>

    <!-- INTERACTIVE JAVASCRIPT LOGIC -->
    <script>
        // Mode Gelap / Terang
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

        // Drawer Auth (Masuk / Daftar)
        function openAuthDrawer(mode) {
            const drawer = document.getElementById('auth-drawer');
            const overlay = document.getElementById('auth-drawer-overlay');
            const loginBox = document.getElementById('login-box');
            const registerBox = document.getElementById('register-box');

            if (mode === 'register') {
                if (loginBox) loginBox.classList.add('hidden');
                if (registerBox) registerBox.classList.remove('hidden');
            } else {
                if (registerBox) registerBox.classList.add('hidden');
                if (loginBox) loginBox.classList.remove('hidden');
            }

            if (overlay) {
                overlay.classList.remove('opacity-0', 'pointer-events-none');
                overlay.classList.add('opacity-100', 'pointer-events-auto');
            }
            if (drawer) {
                drawer.classList.remove('translate-x-full');
                drawer.classList.add('translate-x-0');
            }
        }

        function closeAuthDrawer() {
            const drawer = document.getElementById('auth-drawer');
            const overlay = document.getElementById('auth-drawer-overlay');
            if (drawer) {
                drawer.classList.remove('translate-x-0');
                drawer.classList.add('translate-x-full');
            }
            if (overlay) {
                overlay.classList.remove('opacity-100', 'pointer-events-auto');
                overlay.classList.add('opacity-0', 'pointer-events-none');
            }
        }

        function switchToLogin() { openAuthDrawer('login'); }
        function switchToRegister() { openAuthDrawer('register'); }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeAuthDrawer();
        });

        // Kalkulator Anggaran 50/30/20
        const incomeInput = document.getElementById('incomeInput');
        const needsResult = document.getElementById('needsResult');
        const wantsResult = document.getElementById('wantsResult');
        const savingsResult = document.getElementById('savingsResult');
        const presetBtns = document.querySelectorAll('.preset-btn');

        function formatRupiah(num) {
            return 'Rp ' + Math.round(num).toLocaleString('id-ID');
        }

        function calculateBudget(income) {
            const val = parseFloat(income) || 0;
            if (needsResult) needsResult.textContent = formatRupiah(val * 0.50);
            if (wantsResult) wantsResult.textContent = formatRupiah(val * 0.30);
            if (savingsResult) savingsResult.textContent = formatRupiah(val * 0.20);
        }

        if (incomeInput) {
            incomeInput.addEventListener('input', (e) => calculateBudget(e.target.value));
        }

        presetBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const amount = btn.getAttribute('data-amount');
                if (incomeInput) {
                    incomeInput.value = amount;
                    calculateBudget(amount);
                }
                presetBtns.forEach(b => {
                    b.classList.remove('bg-[#4ABDAC]', 'text-white', 'shadow-sm');
                    b.classList.add('bg-slate-100', 'dark:bg-slate-800', 'text-slate-700', 'dark:text-slate-300');
                });
                btn.classList.add('bg-[#4ABDAC]', 'text-white', 'shadow-sm');
                btn.classList.remove('bg-slate-100', 'dark:bg-slate-800', 'text-slate-700', 'dark:text-slate-300');
            });
        });
    </script>
</body>
</html>