<!DOCTYPE html>
<html lang="id" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CATATUANG</title>
    <!-- CDN Tailwind CSS (Langsung aktif dan rapi tanpa perlu build) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js untuk grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 min-h-screen w-full max-w-full overflow-x-hidden text-slate-800 antialiased">

    <!-- 1. NAVBAR ATAS -->
    <header class="bg-white/95 backdrop-blur border-b border-slate-200 sticky top-0 z-30 shadow-sm transition-all duration-300 ease-in-out">
        <div class="max-w-7xl mx-auto px-4 md:px-8 py-3 md:py-4 flex items-center justify-between gap-3 transition-all duration-300 ease-in-out">
            <div class="flex items-center gap-2.5 md:gap-3 min-w-0">
                <div class="w-9 h-9 md:w-10 md:h-10 shrink-0 rounded-xl bg-teal-600 text-white flex items-center justify-center shadow-sm transition-all duration-300 ease-in-out">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h1 class="text-sm md:text-base font-bold text-slate-900 leading-tight truncate">CATATUANG</h1>
                    <p class="hidden sm:block text-xs text-slate-400 truncate">Dashboard Pengelolaan Keuangan</p>
                </div>
            </div>

            <!-- Info User & Tombol Keluar di Kanan Atas -->
            <div class="flex items-center gap-2 md:gap-4 shrink-0">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 shrink-0 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold text-sm uppercase">
                        {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="hidden md:block text-right max-w-[12rem]">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                        <p class="text-[11px] text-slate-400 truncate">{{ Auth::user()->email ?? '' }}</p>
                    </div>
                </div>

                <!-- Tombol Logout Rapi -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-1.5 px-2.5 sm:px-3 py-2 sm:py-1.5 rounded-xl text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 border border-red-100 transition-all duration-300 ease-in-out" aria-label="Keluar">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- 2. KONTEN UTAMA DASHBOARD -->
    <main class="w-full max-w-7xl mx-auto px-4 md:px-8 py-5 md:py-8 space-y-4 md:space-y-6 transition-all duration-300 ease-in-out">

        <!-- Welcome Banner -->
        <div class="p-5 md:p-8 rounded-2xl bg-gradient-to-br from-teal-600 to-teal-700 text-white shadow-md flex flex-col md:flex-row md:items-center justify-between gap-4 md:gap-6 transition-all duration-300 ease-in-out">
            <div class="min-w-0">
                <h2 class="text-lg md:text-2xl font-bold break-words transition-all duration-300 ease-in-out">Halo, {{ Auth::user()->name ?? 'Pengguna' }}! 👋</h2>
                <p class="text-teal-100 text-xs md:text-sm mt-1">Selamat datang kembali di sistem pencatatan keuangan Anda.</p>
            </div>
            <!-- Tombol Tambah Transaksi -->
            <a href="{{ route('transactions.create') }}" class="w-full md:w-auto shrink-0 bg-white text-teal-700 hover:bg-teal-50 font-bold px-4 py-3 md:py-2.5 rounded-xl text-sm md:text-xs shadow-sm inline-flex items-center justify-center gap-1.5 transition-all duration-300 ease-in-out">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                <span>Catat Transaksi</span>
            </a>
        </div>

        <!-- 3 Kartu Metrik Keuangan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 md:gap-6 transition-all duration-300 ease-in-out">
            <!-- Saldo (lebar penuh di tablet agar 3 kartu tidak sesak) -->
            <div class="sm:col-span-2 lg:col-span-1 min-w-0 bg-white p-4 md:p-6 rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 ease-in-out">
                <span class="text-[11px] md:text-xs font-bold uppercase tracking-wide text-slate-400">Total Saldo Kas</span>
                <p class="text-xl md:text-2xl font-bold text-slate-900 mt-1 md:mt-2 break-words transition-all duration-300 ease-in-out">
                    Rp {{ number_format($totalBalance ?? 0, 0, ',', '.') }}
                </p>
                <span class="text-xs text-teal-600 font-medium mt-1 block">Akumulasi keseluruhan</span>
            </div>

            <!-- Pemasukan -->
            <div class="min-w-0 bg-white p-4 md:p-6 rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 ease-in-out">
                <span class="text-[11px] md:text-xs font-bold uppercase tracking-wide text-teal-600">Pemasukan Bulan Ini</span>
                <p class="text-xl md:text-2xl font-bold text-teal-600 mt-1 md:mt-2 break-words transition-all duration-300 ease-in-out">
                    Rp {{ number_format($thisMonthIncome ?? 0, 0, ',', '.') }}
                </p>
                <span class="text-xs text-slate-400 mt-1 block">Inflow</span>
            </div>

            <!-- Pengeluaran -->
            <div class="min-w-0 bg-white p-4 md:p-6 rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 ease-in-out">
                <span class="text-[11px] md:text-xs font-bold uppercase tracking-wide text-rose-500">Pengeluaran Bulan Ini</span>
                <p class="text-xl md:text-2xl font-bold text-rose-500 mt-1 md:mt-2 break-words transition-all duration-300 ease-in-out">
                    Rp {{ number_format($thisMonthExpense ?? 0, 0, ',', '.') }}
                </p>
                <span class="text-xs text-slate-400 mt-1 block">Outflow</span>
            </div>
        </div>

        <!-- Tabel Transaksi Terkini -->
        <div class="bg-white p-4 md:p-6 rounded-2xl border border-slate-200 shadow-sm transition-all duration-300 ease-in-out">
            <h3 class="font-bold text-slate-800 text-sm md:text-base mb-3 md:mb-4">Transaksi Terkini</h3>

            {{-- Mobile: daftar kartu (tabel 4 kolom terlalu sesak di layar kecil) --}}
            <ul class="md:hidden divide-y divide-slate-100">
                @forelse($recentTransactions ?? [] as $tx)
                    <li class="flex items-center justify-between gap-3 py-3">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-slate-800 truncate">{{ $tx->description ?: ($tx->category?->name ?? 'Umum') }}</p>
                            <p class="text-xs text-slate-400 truncate">
                                {{ $tx->category?->name ?? 'Umum' }} &middot; {{ $tx->transaction_date->format('d M Y') }}
                            </p>
                        </div>
                        <span class="shrink-0 whitespace-nowrap text-sm font-bold {{ $tx->type === 'income' ? 'text-teal-600' : 'text-rose-500' }}">
                            {{ $tx->formatted_amount ?? $tx->amount }}
                        </span>
                    </li>
                @empty
                    <li class="text-center py-6 text-slate-400 text-xs">Belum ada transaksi yang dicatat.</li>
                @endforelse
            </ul>

            {{-- Tablet & desktop: tabel penuh --}}
            <div class="hidden md:block overflow-x-auto -mx-6 px-6">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs uppercase bg-slate-50 text-slate-500 border-b">
                        <tr>
                            <th class="py-3 px-4 whitespace-nowrap">Tanggal</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Keterangan</th>
                            <th class="py-3 px-4 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentTransactions ?? [] as $tx)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-3 px-4 text-xs text-slate-500 whitespace-nowrap">{{ $tx->transaction_date->format('d M Y') }}</td>
                                <td class="py-3 px-4">{{ $tx->category?->name ?? 'Umum' }}</td>
                                <td class="py-3 px-4 max-w-xs truncate">{{ $tx->description }}</td>
                                <td class="py-3 px-4 text-right font-bold whitespace-nowrap {{ $tx->type === 'income' ? 'text-teal-600' : 'text-rose-500' }}">
                                    {{ $tx->formatted_amount ?? $tx->amount }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-6 text-slate-400 text-xs">
                                    Belum ada transaksi yang dicatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>
