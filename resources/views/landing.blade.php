<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth bg-white dark:bg-neutral-950 text-neutral-800 dark:text-neutral-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Aplikasi Keuangan Modern - Wireframe Landing Page Hitam Putih.">
    <title>CATATUANG - Kelola Uang Makin Gampang (Wireframe)</title>

    <!-- Theme Initialization Script -->
    <script>
        if (localStorage.getItem('catatuang_theme') === 'dark' || 
            (!localStorage.getItem('catatuang_theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Google Fonts: Manrope -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Support Vite jika ada, atau fallback ke Tailwind CDN agar langsung jalan) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Manrope', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        /* Wireframe Monochrome Style */
        .btn-catat-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 700;
            background-color: #171717;
            color: #ffffff;
            border: 2px solid #171717;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-catat-primary:hover {
            background-color: #404040;
            border-color: #404040;
            transform: translateY(-1px);
        }
        .dark .btn-catat-primary {
            background-color: #f5f5f5;
            color: #171717;
            border-color: #f5f5f5;
        }
        .dark .btn-catat-primary:hover {
            background-color: #e5e5e5;
            border-color: #e5e5e5;
        }

        .btn-catat-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 700;
            background-color: #ffffff;
            color: #171717;
            border: 2px solid #171717;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-catat-outline:hover {
            background-color: #f5f5f5;
            transform: translateY(-1px);
        }
        .dark .btn-catat-outline {
            background-color: #171717;
            color: #f5f5f5;
            border-color: #737373;
        }
        .dark .btn-catat-outline:hover {
            background-color: #262626;
        }

        .card-custom {
            background-color: #ffffff;
            border: 1px solid #e5e5e5;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
            transition: all 0.2s ease;
        }
        .card-custom:hover {
            border-color: #171717;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }
        .dark .card-custom {
            background-color: #171717;
            border-color: #262626;
        }
        .dark .card-custom:hover {
            border-color: #737373;
        }
    </style>
</head>
<body class="min-h-full bg-neutral-50 dark:bg-neutral-950 font-sans antialiased text-neutral-800 dark:text-neutral-200 relative overflow-x-hidden transition-colors duration-300">

    <!-- Subtle Monochrome Background Pattern -->
    <div class="pointer-events-none fixed inset-0 z-0 overflow-hidden opacity-30 dark:opacity-10">
        <div class="absolute -top-40 left-1/4 w-[600px] h-[500px] bg-neutral-300 dark:bg-neutral-700 rounded-full blur-3xl"></div>
        <div class="absolute bottom-10 right-1/4 w-[500px] h-[400px] bg-neutral-400 dark:bg-neutral-600 rounded-full blur-3xl"></div>
    </div>

    <!-- TOP NAVIGATION BAR -->
    <header class="relative z-30 w-full border-b border-neutral-200 dark:border-neutral-800 bg-white/90 dark:bg-neutral-900/90 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo (Monochrome) -->
            <a href="{{ Route::has('landing') ? route('landing') : url('/') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-neutral-900 dark:bg-white text-white dark:text-neutral-950 flex items-center justify-center font-black text-lg transition-transform group-hover:scale-105">
                    C
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xl font-extrabold tracking-tight text-neutral-900 dark:text-white">CATATUANG</span>
                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-neutral-200 dark:bg-neutral-800 text-neutral-600 dark:text-neutral-400">WIREFRAME</span>
                    </div>
                    <p class="text-[11px] text-neutral-500 font-medium hidden sm:block">Kelola Uang Makin Gampang</p>
                </div>
            </a>

            <!-- Nav Links & Auth Trigger -->
            <nav class="flex items-center gap-3 sm:gap-5">
                <a href="#fitur" class="text-sm font-semibold text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white transition">Fitur</a>
                <a href="#kalkulator" class="text-sm font-semibold text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white transition hidden sm:inline-block">Kalkulator</a>

                <!-- Theme Toggle Button -->
                <button type="button" onclick="toggleTheme()" class="p-2 rounded-xl bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-neutral-600 dark:text-neutral-300 hover:border-neutral-400 transition" title="Ganti Mode Terang / Gelap">
                    <svg class="theme-icon-sun hidden w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <svg class="theme-icon-moon w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                    </svg>
                </button>

                <!-- Auth Buttons (Membuka Slide Drawer) -->
                <button type="button" onclick="openAuthDrawer('login')" class="btn-catat-outline px-4 sm:px-5 py-2 text-xs sm:text-sm">
                    Masuk
                </button>
                <button type="button" onclick="openAuthDrawer('register')" class="btn-catat-primary px-4 sm:px-5 py-2 text-xs sm:text-sm">
                    Daftar
                </button>
            </nav>
        </div>
    </header>

    <!-- HERO SECTION -->
    <section class="relative z-10 w-full min-h-[calc(100vh-80px)] flex items-center py-12 lg:py-20 border-b border-neutral-200 dark:border-neutral-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                
                <!-- Left Column: Headline & CTA -->
                <div class="lg:col-span-7">
                    <!-- Pill Tag -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-neutral-100 dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-700 text-neutral-800 dark:text-neutral-200 text-xs font-semibold mb-6">
                        <span class="w-2 h-2 rounded-full bg-neutral-900 dark:bg-neutral-300 animate-pulse"></span>
                        CATATUANG / Versi Pratinjau Wireframe
                    </div>

                    <!-- Main Headline -->
                    <h1 class="text-4xl sm:text-5xl lg:text-5xl font-extrabold text-neutral-900 dark:text-white leading-[1.15] mb-4">
                        Kendalikan Keuangan <br class="hidden sm:inline">
                        <span class="text-neutral-500 dark:text-neutral-400">Anda Mulai Hari Ini</span>
                    </h1>

                    <!-- Subtitle -->
                    <h2 class="text-xl sm:text-2xl font-bold text-neutral-700 dark:text-neutral-300 mb-6">
                        Kelola Uang Makin Gampang Bersama CatatUang
                    </h2>

                    <!-- Body Description -->
                    <p class="text-neutral-600 dark:text-neutral-400 text-base sm:text-lg leading-relaxed mb-8 max-w-xl">
                        Catat pemasukan dan pengeluaran harian dengan cepat, visualisasikan grafik pergerakan uang, dan capai kebebasan finansial tanpa ribet.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap items-center gap-4 mb-10">
                        <button type="button" onclick="openAuthDrawer('register')" class="btn-catat-primary text-base px-7 py-3">
                            <span>Daftar Gratis</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </button>
                        <button type="button" onclick="openAuthDrawer('login')" class="btn-catat-outline text-base px-7 py-3">
                            <span>Masuk ke Akun Anda</span>
                        </button>
                    </div>

                    <!-- Highlights Checkmarks (Monokrom) -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-6 border-t border-neutral-200 dark:border-neutral-800 text-xs font-semibold text-neutral-600 dark:text-neutral-400">
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-white flex items-center justify-center font-bold">✓</span>
                            <span>100% Gratis & Bebas Biaya</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-white flex items-center justify-center font-bold">★</span>
                            <span>Visualisasi Arus Kas Real-time</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-5 h-5 rounded-full bg-neutral-200 dark:bg-neutral-800 text-neutral-900 dark:text-white flex items-center justify-center font-bold">🔒</span>
                            <span>Data Aman & Terenkripsi</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Mockup Wireframe Card -->
                <div class="lg:col-span-5 relative">
                    <div class="relative bg-white dark:bg-neutral-900 border-2 border-neutral-200 dark:border-neutral-800 rounded-3xl p-6 sm:p-7 shadow-xl">
                        <!-- Mockup Header -->
                        <div class="flex items-center justify-between pb-4 border-b border-neutral-200 dark:border-neutral-800 mb-5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-neutral-900 dark:bg-white text-white dark:text-neutral-950 flex items-center justify-center font-bold text-sm">
                                    C
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-neutral-900 dark:text-white">CatatUang Dashboard</h4>
                                    <p class="text-[10px] text-neutral-400 font-medium">Ringkasan Bulan Ini (Mockup)</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 border border-neutral-300 dark:border-neutral-700">
                                Aktif
                            </span>
                        </div>

                        <!-- 2 Metrics -->
                        <div class="grid grid-cols-2 gap-3 mb-5">
                            <div class="p-3.5 rounded-2xl bg-neutral-50 dark:bg-neutral-800/60 border border-neutral-200 dark:border-neutral-700">
                                <span class="text-[11px] font-semibold text-neutral-500">Pemasukan</span>
                                <p class="text-base sm:text-lg font-black text-neutral-900 dark:text-white mt-0.5">+ Rp 14.500.000</p>
                                <span class="text-[9px] font-bold text-neutral-700 dark:text-neutral-300 bg-neutral-200 dark:bg-neutral-700 px-1.5 py-0.5 rounded">Inflow</span>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-neutral-50 dark:bg-neutral-800/60 border border-neutral-200 dark:border-neutral-700">
                                <span class="text-[11px] font-semibold text-neutral-500">Pengeluaran</span>
                                <p class="text-base sm:text-lg font-black text-neutral-700 dark:text-neutral-300 mt-0.5">- Rp 5.250.000</p>
                                <span class="text-[9px] font-bold text-neutral-700 dark:text-neutral-300 bg-neutral-200 dark:bg-neutral-700 px-1.5 py-0.5 rounded">Outflow</span>
                            </div>
                        </div>

                        <!-- Allocation Bar (Shades of Gray) -->
                        <div class="p-4 rounded-2xl bg-neutral-50 dark:bg-neutral-800/60 border border-neutral-200 dark:border-neutral-700 mb-5">
                            <div class="flex items-center justify-between text-xs font-bold mb-2">
                                <span class="text-neutral-700 dark:text-neutral-300">Alokasi Anggaran Bulanan</span>
                                <span class="text-neutral-900 dark:text-white font-extrabold">64% Sisa Saldo</span>
                            </div>
                            <div class="w-full bg-neutral-200 dark:bg-neutral-700 h-3 rounded-full overflow-hidden flex">
                                <div class="bg-neutral-900 dark:bg-white h-full" style="width: 50%" title="Kebutuhan (50%)"></div>
                                <div class="bg-neutral-500 h-full" style="width: 25%" title="Tabungan (25%)"></div>
                                <div class="bg-neutral-300 dark:bg-neutral-600 h-full" style="width: 25%" title="Pengeluaran (25%)"></div>
                            </div>
                            <div class="flex items-center justify-between text-[10px] text-neutral-500 font-semibold mt-2">
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-neutral-900 dark:bg-white"></span> Kebutuhan</span>
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-neutral-500"></span> Tabungan</span>
                                <span class="flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-neutral-300 dark:bg-neutral-600"></span> Keinginan</span>
                            </div>
                        </div>

                        <!-- Sample Transactions -->
                        <div class="space-y-2">
                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-xs">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-6 h-6 rounded bg-neutral-100 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-200 flex items-center justify-center font-bold">↓</div>
                                    <div>
                                        <p class="font-bold text-neutral-800 dark:text-neutral-200">Gaji Bulanan</p>
                                        <span class="text-[10px] text-neutral-400">Pekerjaan Utama</span>
                                    </div>
                                </div>
                                <span class="font-bold text-neutral-900 dark:text-white">+ Rp 12.000.000</span>
                            </div>

                            <div class="flex items-center justify-between p-2.5 rounded-xl bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 text-xs">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-6 h-6 rounded bg-neutral-100 dark:bg-neutral-700 text-neutral-800 dark:text-neutral-200 flex items-center justify-center font-bold">↑</div>
                                    <div>
                                        <p class="font-bold text-neutral-800 dark:text-neutral-200">Belanja Kebutuhan</p>
                                        <span class="text-[10px] text-neutral-400">Supermarket</span>
                                    </div>
                                </div>
                                <span class="font-bold text-neutral-600 dark:text-neutral-400">- Rp 1.450.000</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SLIDE-OVER AUTH DRAWER (INTERAKTIF WIREFRAME) -->
    <div id="auth-drawer-overlay" 
         onclick="closeAuthDrawer()" 
         class="opacity-0 pointer-events-none fixed inset-0 z-50 bg-black/60 backdrop-blur-xs transition-opacity duration-300">
    </div>

    <aside id="auth-drawer" 
           class="translate-x-full fixed inset-y-0 right-0 z-50 w-full sm:w-[460px] bg-white dark:bg-neutral-900 border-l border-neutral-200 dark:border-neutral-800 shadow-2xl transition-transform duration-300 ease-out flex flex-col justify-between overflow-y-auto">
        <div class="p-6 sm:p-8">
            <!-- Header -->
            <div class="flex items-center justify-between pb-6 border-b border-neutral-200 dark:border-neutral-800">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-lg bg-neutral-900 dark:bg-white text-white dark:text-neutral-950 flex items-center justify-center font-black">
                        C
                    </div>
                    <div>
                        <span class="text-base font-bold text-neutral-900 dark:text-white">CATATUANG</span>
                        <p class="text-[10px] text-neutral-400">Wireframe Auth Dialog</p>
                    </div>
                </div>
                <button type="button" onclick="closeAuthDrawer()" class="p-2 rounded-lg text-neutral-400 hover:text-neutral-700 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- 1. LOGIN FORM -->
            <div id="login-box" class="pt-6">
                <div class="mb-5">
                    <h3 class="text-2xl font-bold text-neutral-900 dark:text-white">Masuk ke Akun Anda</h3>
                    <p class="text-xs text-neutral-500 mt-1">Gunakan formulir login ini untuk mengakses sistem pembukuan.</p>
                </div>

                <form onsubmit="event.preventDefault(); alert('Demo Wireframe: Rute backend auth belum dihubungkan pada tahap ini.');" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">Email / Username</label>
                        <input type="text" placeholder="nama@email.com" class="w-full px-4 py-2.5 rounded-xl bg-neutral-50 dark:bg-neutral-950 border border-neutral-300 dark:border-neutral-700 text-sm focus:outline-none focus:border-neutral-900 dark:focus:border-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1.5">Kata Sandi</label>
                        <input type="password" placeholder="Kata Sandi Anda" class="w-full px-4 py-2.5 rounded-xl bg-neutral-50 dark:bg-neutral-950 border border-neutral-300 dark:border-neutral-700 text-sm focus:outline-none focus:border-neutral-900 dark:focus:border-white">
                    </div>
                    <button type="submit" class="btn-catat-primary w-full text-center">
                        Masuk Sekarang
                    </button>
                </form>

                <div class="mt-6 text-center text-xs text-neutral-500">
                    <span>Belum punya akun?</span>
                    <button type="button" onclick="switchToRegister()" class="font-bold text-neutral-900 dark:text-white hover:underline ml-1">
                        Daftar Sekarang
                    </button>
                </div>
            </div>

            <!-- 2. REGISTER FORM -->
            <div id="register-box" class="hidden pt-6">
                <div class="mb-5">
                    <h3 class="text-2xl font-bold text-neutral-900 dark:text-white">Daftar Akun Baru</h3>
                    <p class="text-xs text-neutral-500 mt-1">Buat akun baru untuk mulai mencatat keuangan harian.</p>
                </div>

                <form onsubmit="event.preventDefault(); alert('Demo Wireframe: Pendaftaran akun siap dihubungkan ke auth controller berikutnya.');" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1">Nama Lengkap</label>
                        <input type="text" placeholder="Nama Anda" class="w-full px-4 py-2.5 rounded-xl bg-neutral-50 dark:bg-neutral-950 border border-neutral-300 dark:border-neutral-700 text-sm focus:outline-none focus:border-neutral-900 dark:focus:border-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1">Email</label>
                        <input type="email" placeholder="nama@email.com" class="w-full px-4 py-2.5 rounded-xl bg-neutral-50 dark:bg-neutral-950 border border-neutral-300 dark:border-neutral-700 text-sm focus:outline-none focus:border-neutral-900 dark:focus:border-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-neutral-600 dark:text-neutral-400 mb-1">Kata Sandi</label>
                        <input type="password" placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 rounded-xl bg-neutral-50 dark:bg-neutral-950 border border-neutral-300 dark:border-neutral-700 text-sm focus:outline-none focus:border-neutral-900 dark:focus:border-white">
                    </div>
                    <button type="submit" class="btn-catat-primary w-full text-center">
                        Daftar Akun Baru
                    </button>
                </form>

                <div class="mt-6 text-center text-xs text-neutral-500">
                    <span>Sudah punya akun?</span>
                    <button type="button" onclick="switchToLogin()" class="font-bold text-neutral-900 dark:text-white hover:underline ml-1">
                        Masuk di sini
                    </button>
                </div>
            </div>
        </div>

        <div class="p-6 border-t border-neutral-200 dark:border-neutral-800 text-center bg-neutral-50 dark:bg-neutral-950">
            <p class="text-[11px] text-neutral-400">Tahap 1: Tampilan Landing Page (Hitam Putih Wireframe)</p>
        </div>
    </aside>

    <!-- SECTION FITUR UNGGULAN -->
    <section id="fitur" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="px-3.5 py-1 rounded-full bg-neutral-200 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 text-xs font-bold uppercase tracking-wider border border-neutral-300 dark:border-neutral-700">
                Fitur Unggulan
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-neutral-900 dark:text-white mt-4">
                Didesain Khusus untuk Efisiensi & Kontrol Finansial
            </h2>
            <p class="text-neutral-600 dark:text-neutral-400 text-base mt-3">
                Nikmati kemudahan mencatat dan menganalisis setiap transaksi dalam satu aplikasi modern.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- 1. Pencatatan Instan -->
            <div class="p-7 rounded-3xl card-custom">
                <div class="w-12 h-12 rounded-2xl bg-neutral-100 dark:bg-neutral-800 text-neutral-900 dark:text-white flex items-center justify-center mb-5 font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">Pencatatan Instan 5 Detik</h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">Catat pengeluaran dan pemasukan dengan cepat lengkap dengan kategori, nominal, dan tanggal transaksi.</p>
            </div>

            <!-- 2. Grafik Arus Kas -->
            <div class="p-7 rounded-3xl card-custom">
                <div class="w-12 h-12 rounded-2xl bg-neutral-100 dark:bg-neutral-800 text-neutral-900 dark:text-white flex items-center justify-center mb-5 font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">Grafik Tren Arus Kas 6 Bulan</h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">Pantau pertumbuhan tabungan dan rasio pemasukan vs pengeluaran Anda dengan visualisasi grafik interaktif.</p>
            </div>

            <!-- 3. Kategori Kustom -->
            <div class="p-7 rounded-3xl card-custom">
                <div class="w-12 h-12 rounded-2xl bg-neutral-100 dark:bg-neutral-800 text-neutral-900 dark:text-white flex items-center justify-center mb-5 font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">Kategori Kustom & Fleksibel</h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">Kelompokkan transaksi sesuka hati dengan pengaturan kategori dan sub-kategori yang terorganisir.</p>
            </div>

            <!-- 4. Laporan Neraca -->
            <div class="p-7 rounded-3xl card-custom">
                <div class="w-12 h-12 rounded-2xl bg-neutral-100 dark:bg-neutral-800 text-neutral-900 dark:text-white flex items-center justify-center mb-5 font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">Laporan & Filter Periode</h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">Filter transaksi berdasarkan rentang tanggal, kategori, atau tipe untuk evaluasi anggaran berkala.</p>
            </div>

            <!-- 5. Ekspor Sekali Klik -->
            <div class="p-7 rounded-3xl card-custom">
                <div class="w-12 h-12 rounded-2xl bg-neutral-100 dark:bg-neutral-800 text-neutral-900 dark:text-white flex items-center justify-center mb-5 font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </div>
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">Ekspor CSV Spreadsheet</h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">Unduh seluruh riwayat pembukuan ke format CSV untuk dibuka di Microsoft Excel atau Google Sheets.</p>
            </div>

            <!-- 6. Privasi Database Lokal -->
            <div class="p-7 rounded-3xl card-custom">
                <div class="w-12 h-12 rounded-2xl bg-neutral-100 dark:bg-neutral-800 text-neutral-900 dark:text-white flex items-center justify-center mb-5 font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-neutral-900 dark:text-white mb-2">100% Privasi & Data Lokal</h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">Data Anda tersimpan di server database lokal Anda sendiri, tanpa pelacak atau iklan pihak ketiga.</p>
            </div>
        </div>
    </section>

    <!-- SECTION KALKULATOR ANGGARAN 50/30/20 -->
    <section id="kalkulator" class="py-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="p-8 sm:p-12 rounded-3xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 shadow-lg">
            <div class="max-w-3xl mx-auto text-center mb-8">
                <span class="px-3.5 py-1 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 text-xs font-bold uppercase tracking-wider border border-neutral-300 dark:border-neutral-700">
                    Kalkulator Interaktif
                </span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-neutral-900 dark:text-white mt-4">
                    Kalkulator Aturan Anggaran 50 / 30 / 20
                </h2>
                <p class="text-neutral-600 dark:text-neutral-400 text-sm sm:text-base mt-2">
                    Ketahui alokasi penghasilan ideal: 50% Kebutuhan, 30% Keinginan, dan 20% Tabungan / Investasi.
                </p>
            </div>

            <div class="max-w-xl mx-auto space-y-6">
                <div>
                    <label for="incomeInput" class="block text-xs font-bold uppercase tracking-wider text-neutral-700 dark:text-neutral-300 mb-2">
                        Pemasukan Bulanan Anda (Rp)
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-neutral-400 font-bold text-base">
                            Rp
                        </span>
                        <input 
                            type="number" 
                            id="incomeInput" 
                            value="10000000" 
                            step="500000" 
                            min="100000"
                            class="w-full pl-14 pr-4 py-3 rounded-2xl bg-neutral-50 dark:bg-neutral-950 border border-neutral-300 dark:border-neutral-700 text-neutral-900 dark:text-white font-bold text-lg focus:outline-none focus:border-neutral-900 dark:focus:border-white transition"
                        >
                    </div>
                </div>

                <!-- Presets -->
                <div class="flex flex-wrap items-center justify-center gap-2">
                    <span class="text-xs text-neutral-500 font-medium">Contoh:</span>
                    <button type="button" class="preset-btn px-3 py-1.5 rounded-xl bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 text-xs font-bold transition hover:bg-neutral-200" data-amount="5000000">Rp 5 Juta</button>
                    <button type="button" class="preset-btn px-3 py-1.5 rounded-xl bg-neutral-900 text-white dark:bg-white dark:text-neutral-900 text-xs font-bold transition shadow-sm" data-amount="10000000">Rp 10 Juta</button>
                    <button type="button" class="preset-btn px-3 py-1.5 rounded-xl bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 text-xs font-bold transition hover:bg-neutral-200" data-amount="20000000">Rp 20 Juta</button>
                    <button type="button" class="preset-btn px-3 py-1.5 rounded-xl bg-neutral-100 dark:bg-neutral-800 text-neutral-700 dark:text-neutral-300 text-xs font-bold transition hover:bg-neutral-200" data-amount="35000000">Rp 35 Juta</button>
                </div>

                <!-- 3 Allocation Cards (Monokrom) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-3">
                    <div class="p-4 rounded-2xl bg-neutral-100 dark:bg-neutral-800/80 border border-neutral-300 dark:border-neutral-700">
                        <span class="text-xs font-bold text-neutral-700 dark:text-neutral-300">50% Kebutuhan</span>
                        <p id="needsResult" class="text-lg font-black text-neutral-900 dark:text-white mt-1">Rp 5.000.000</p>
                        <p class="text-[11px] text-neutral-500 mt-1">Makanan, rumah, tagihan.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-neutral-100 dark:bg-neutral-800/80 border border-neutral-300 dark:border-neutral-700">
                        <span class="text-xs font-bold text-neutral-700 dark:text-neutral-300">30% Keinginan</span>
                        <p id="wantsResult" class="text-lg font-black text-neutral-900 dark:text-white mt-1">Rp 3.000.000</p>
                        <p class="text-[11px] text-neutral-500 mt-1">Hiburan, belanja, gaya hidup.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-neutral-100 dark:bg-neutral-800/80 border border-neutral-300 dark:border-neutral-700">
                        <span class="text-xs font-bold text-neutral-700 dark:text-neutral-300">20% Tabungan</span>
                        <p id="savingsResult" class="text-lg font-black text-neutral-900 dark:text-white mt-1">Rp 2.000.000</p>
                        <p class="text-[11px] text-neutral-500 mt-1">Dana darurat & investasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER (MONOCHROME) -->
    <footer class="border-t border-neutral-200 dark:border-neutral-800 bg-white dark:bg-neutral-950 py-12 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-neutral-900 dark:bg-white text-white dark:text-neutral-950 flex items-center justify-center font-bold text-sm">
                    C
                </div>
                <div>
                    <span class="text-base font-bold text-neutral-900 dark:text-white">CATATUANG</span>
                    <span class="text-xs text-neutral-500 ml-2">• Versi Wireframe Hitam Putih</span>
                </div>
            </div>

            <div class="flex items-center gap-6 text-xs font-bold text-neutral-600 dark:text-neutral-400">
                <a href="#fitur" class="hover:text-neutral-900 dark:hover:text-white transition">Fitur</a>
                <a href="#kalkulator" class="hover:text-neutral-900 dark:hover:text-white transition">Kalkulator</a>
                <button type="button" onclick="openAuthDrawer('login')" class="hover:text-neutral-900 dark:hover:text-white transition">Masuk</button>
                <button type="button" onclick="openAuthDrawer('register')" class="hover:text-neutral-900 dark:hover:text-white transition">Daftar</button>
            </div>

            <p class="text-xs text-neutral-400">&copy; {{ date('Y') }} CatatUang. Wireframe Landing.</p>
        </div>
    </footer>

    <!-- INTERACTIVE JAVASCRIPT LOGIC -->
    <script>
        // Theme Toggle (Dark/Light)
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

        // Slide-Over Auth Drawer
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

        function switchToLogin() {
            openAuthDrawer('login');
        }

        function switchToRegister() {
            openAuthDrawer('register');
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeAuthDrawer();
        });

        // Kalkulator 50/30/20 Reactive Logic
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
            incomeInput.addEventListener('input', (e) => {
                calculateBudget(e.target.value);
            });
        }

        presetBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const amount = btn.getAttribute('data-amount');
                if (incomeInput) {
                    incomeInput.value = amount;
                    calculateBudget(amount);
                }
                presetBtns.forEach(b => {
                    b.classList.remove('bg-neutral-900', 'text-white', 'dark:bg-white', 'dark:text-neutral-900', 'shadow-sm');
                    b.classList.add('bg-neutral-100', 'dark:bg-neutral-800', 'text-neutral-700', 'dark:text-neutral-300');
                });
                btn.classList.add('bg-neutral-900', 'text-white', 'dark:bg-white', 'dark:text-neutral-900', 'shadow-sm');
                btn.classList.remove('bg-neutral-100', 'dark:bg-neutral-800', 'text-neutral-700', 'dark:text-neutral-300');
            });
        });
    </script>
</body>
</html>
