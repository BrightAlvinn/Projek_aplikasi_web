<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - CatatUang</title>
    <!-- CDN Tailwind CSS (Langsung aktif dan rapi tanpa perlu build) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js untuk grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800">

    <!-- 1. NAVBAR ATAS -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-30 px-6 py-4 flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-teal-600 text-white font-bold flex items-center justify-center text-lg shadow-sm">
                C
            </div>
            <div>
                <h1 class="text-base font-bold text-slate-900 leading-tight">CatatUang</h1>
                <p class="text-xs text-slate-400">Dashboard Pengelolaan Keuangan</p>
            </div>
        </div>

        <!-- Info User & Tombol Keluar di Kanan Atas -->
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold text-sm uppercase">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="hidden sm:block text-right">
                    <p class="text-xs font-bold text-slate-800">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                    <p class="text-[11px] text-slate-400">{{ Auth::user()->email ?? '' }}</p>
                </div>
            </div>

            <!-- Tombol Logout Rapi -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 transition border border-red-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </header>

    <!-- 2. KONTEN UTAMA DASHBOARD -->
    <main class="max-w-7xl mx-auto px-6 py-8 space-y-6">

        <!-- Welcome Banner -->
        <div class="p-6 rounded-2xl bg-teal-600 text-white shadow-md flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold">Halo, {{ Auth::user()->name ?? 'Pengguna' }}! 👋</h2>
                <p class="text-teal-100 text-xs mt-1">Selamat datang kembali di sistem pencatatan keuangan Anda.</p>
            </div>
        </div>

        <!-- 3 Kartu Metrik Keuangan -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <!-- Saldo -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-xs font-bold uppercase text-slate-400">Total Saldo Kas</span>
                <p class="text-2xl font-bold text-slate-900 mt-2">
                    Rp {{ number_format($totalBalance ?? 0, 0, ',', '.') }}
                </p>
                <span class="text-xs text-teal-600 font-medium mt-1 block">Akumulasi keseluruhan</span>
            </div>

            <!-- Pemasukan -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-xs font-bold uppercase text-teal-600">Pemasukan Bulan Ini</span>
                <p class="text-2xl font-bold text-teal-600 mt-2">
                    Rp {{ number_format($thisMonthIncome ?? 0, 0, ',', '.') }}
                </p>
                <span class="text-xs text-slate-400 mt-1 block">Inflow</span>
            </div>

            <!-- Pengeluaran -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-xs font-bold uppercase text-rose-500">Pengeluaran Bulan Ini</span>
                <p class="text-2xl font-bold text-rose-500 mt-2">
                    Rp {{ number_format($thisMonthExpense ?? 0, 0, ',', '.') }}
                </p>
                <span class="text-xs text-slate-400 mt-1 block">Outflow</span>
            </div>
        </div>

        <!-- Tabel Transaksi Terkini -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="font-bold text-slate-800 text-sm mb-4">Transaksi Terkini</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs uppercase bg-slate-50 text-slate-500 border-b">
                        <tr>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Kategori</th>
                            <th class="py-3 px-4">Keterangan</th>
                            <th class="py-3 px-4 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentTransactions ?? [] as $tx)
                            <tr>
                                <td class="py-3 px-4 text-xs text-slate-500">{{ $tx->transaction_date->format('d M Y') }}</td>
                                <td class="py-3 px-4">{{ $tx->category?->name ?? 'Umum' }}</td>
                                <td class="py-3 px-4">{{ $tx->description }}</td>
                                <td class="py-3 px-4 text-right font-bold {{ $tx->type === 'income' ? 'text-teal-600' : 'text-rose-500' }}">
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
