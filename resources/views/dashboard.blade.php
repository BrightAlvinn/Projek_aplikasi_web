@extends('layouts.app')

@section('title', 'Ringkasan Keuangan')
@section('page_title', 'Ringkasan Keuangan')

@section('content')

    <!-- WIREFRAME ELEMENT 1: USER BANNER & QUICK ACTIONS -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4 transition-colors">
        <!-- User Info (Kiri) - Clickable to Profile -->
        <a href="{{ route('profile') }}" class="flex items-center gap-3.5 w-full sm:w-auto hover:opacity-90 transition group cursor-pointer" title="Klik untuk membuka Profil User">
            <div class="w-12 h-12 rounded-full bg-[#4ABDAC] text-white flex items-center justify-center font-extrabold text-base shadow-xs shrink-0 group-hover:scale-105 transition-transform">
                {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
            </div>
            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    <p class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white truncate group-hover:text-[#4ABDAC] transition-colors">{{ Auth::user()->name ?? 'Pengguna' }}</p>
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">Aktif</span>
                </div>
                <p class="text-xs text-slate-400 dark:text-slate-500 truncate">{{ Auth::user()->email ?? '' }}</p>
            </div>
        </a>

        <!-- Quick Action Buttons (Kanan): + Pemasukan, - Pengeluaran -->
        <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
            <!-- + Pemasukan -->
            <a href="{{ route('transactions.create', ['type' => 'income']) }}" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-emerald-500 hover:bg-emerald-50/50 dark:hover:bg-emerald-950/30 text-slate-700 dark:text-slate-200 hover:text-emerald-700 dark:hover:text-emerald-400 text-xs font-bold shadow-2xs transition">
                <span class="text-emerald-600 dark:text-emerald-400 font-extrabold text-sm">+</span>
                <span>Pemasukan</span>
            </a>
            <!-- - Pengeluaran -->
            <a href="{{ route('transactions.create', ['type' => 'expense']) }}" class="flex-1 sm:flex-initial inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 hover:border-rose-500 hover:bg-rose-50/50 dark:hover:bg-rose-950/30 text-slate-700 dark:text-slate-200 hover:text-rose-700 dark:hover:text-rose-400 text-xs font-bold shadow-2xs transition">
                <span class="text-rose-600 dark:text-rose-400 font-extrabold text-sm">&minus;</span>
                <span>Pengeluaran</span>
            </a>
        </div>
    </div>


    <!-- WIREFRAME ELEMENT 2: 4 SUMMARY CARDS (GRID 4 KOLOM) -->
    <!-- Saldo | Pemasukan Bulan ini | Pengeluaran Bulan ini | Arus Kas Net -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- 1. Saldo Card -->
        <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between hover:shadow-sm transition">
            <div class="flex items-center justify-between gap-2 mb-2">
                <span class="text-xs font-bold text-slate-600 dark:text-slate-400">Saldo</span>
                <div class="w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 dark:text-slate-400" title="Total Saldo">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
            </div>
            <div class="my-1">
                <p class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Rp {{ number_format($totalBalance ?? 0, 0, ',', '.') }}
                </p>
            </div>
            <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Total saldo kas aktif saat ini</p>
        </div>

        <!-- 2. Pemasukan Bulan ini Card -->
        <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between hover:shadow-sm transition">
            <div class="flex items-center justify-between gap-2 mb-2">
                <span class="text-xs font-bold text-slate-600 dark:text-slate-400">Pemasukan Bulan ini</span>
                <div class="w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center" title="Pemasukan Bulan Ini">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                    </svg>
                </div>
            </div>
            <div class="my-1">
                <p class="text-xl sm:text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 tracking-tight">
                    Rp {{ number_format($thisMonthIncome ?? 0, 0, ',', '.') }}
                </p>
            </div>
            <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Arus kas masuk bulan berjalan</p>
        </div>

        <!-- 3. Pengeluaran Bulan ini Card -->
        <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between hover:shadow-sm transition">
            <div class="flex items-center justify-between gap-2 mb-2">
                <span class="text-xs font-bold text-slate-600 dark:text-slate-400">Pengeluaran Bulan ini</span>
                <div class="w-7 h-7 rounded-lg bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 flex items-center justify-center" title="Pengeluaran Bulan Ini">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                    </svg>
                </div>
            </div>
            <div class="my-1">
                <p class="text-xl sm:text-2xl font-extrabold text-rose-600 dark:text-rose-400 tracking-tight">
                    Rp {{ number_format($thisMonthExpense ?? 0, 0, ',', '.') }}
                </p>
            </div>
            <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Arus kas keluar bulan berjalan</p>
        </div>

        <!-- 4. Arus Kas Net Card -->
        <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between hover:shadow-sm transition">
            <div class="flex items-center justify-between gap-2 mb-2">
                <span class="text-xs font-bold text-slate-600 dark:text-slate-400">Arus Kas Net</span>
                <div class="w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 flex items-center justify-center" title="Arus Kas Bersih">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
            <div class="my-1">
                <p class="text-xl sm:text-2xl font-extrabold {{ ($thisMonthNet ?? 0) >= 0 ? 'text-[#4ABDAC]' : 'text-rose-500' }} tracking-tight">
                    Rp {{ number_format($thisMonthNet ?? 0, 0, ',', '.') }}
                </p>
            </div>
            <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Surplus bersih bulan berjalan</p>
        </div>

    </div>


    <!-- WIREFRAME ELEMENT 3: DUAL CHARTS SECTION (2 KOLOM) -->
    <!-- Kiri: Tren Arus Kas (M vs K) | Kanan: Pengeluaran per Kategori -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        
        <!-- Left Chart Card: Tren Arus Kas (M vs K) -->
        <div class="lg:col-span-8 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                <div>
                    <h2 class="text-sm font-extrabold text-slate-900 dark:text-white tracking-tight">Tren Arus Kas (M vs K)</h2>
                    <p class="text-[11px] text-slate-400 dark:text-slate-500">Perbandingan Pemasukan (M) vs Pengeluaran (K) 6 bulan terakhir</p>
                </div>
                <!-- Legend Indicators -->
                <div class="flex items-center gap-3 text-xs font-semibold">
                    <span class="inline-flex items-center gap-1.5 text-slate-700 dark:text-slate-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#4ABDAC]"></span>
                        <span>Pemasukan (M)</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-slate-500 dark:text-slate-400">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-400"></span>
                        <span>Pengeluaran (K)</span>
                    </span>
                </div>
            </div>

            <!-- Canvas Chart Area -->
            <div class="relative w-full h-64 sm:h-72">
                <canvas id="cashflowTrendChart"></canvas>
            </div>
        </div>

        <!-- Right Chart Card: Pengeluaran per Kategori -->
        <div class="lg:col-span-4 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs flex flex-col justify-between transition-colors">
            <div class="mb-3">
                <h2 class="text-sm font-extrabold text-slate-900 dark:text-white tracking-tight">Pengeluaran per Kategori</h2>
                <p class="text-[11px] text-slate-400 dark:text-slate-500">Distribusi pengeluaran periode berjalan</p>
            </div>

            <!-- Donut Chart Container -->
            <div class="relative w-full h-52 flex items-center justify-center">
                <canvas id="categoryDonutChart"></canvas>
            </div>

            <!-- Breakdown list -->
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 space-y-2 max-h-36 overflow-y-auto pr-1">
                @forelse($categoryBreakdown ?? [] as $cat)
                    <div class="flex items-center justify-between text-xs font-medium">
                        <div class="flex items-center gap-2 truncate pr-2">
                            <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $cat['color'] ?? '#64748b' }}"></span>
                            <span class="truncate text-slate-700 dark:text-slate-300">{{ $cat['name'] }}</span>
                        </div>
                        <span class="font-bold text-slate-900 dark:text-white shrink-0">{{ $cat['percentage'] }}%</span>
                    </div>
                @empty
                    <div class="text-center py-2 text-slate-400 dark:text-slate-500 text-xs">
                        Belum ada pengeluaran di bulan ini.
                    </div>
                @endforelse
            </div>
        </div>

    </div>


    <!-- WIREFRAME ELEMENT 4: TABEL TRANSAKSI TERKINI (BOTTOM) -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden transition-colors">
        <div class="p-4 sm:p-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between gap-3">
            <h2 class="text-sm sm:text-base font-extrabold text-slate-900 dark:text-white tracking-tight">Tabel Transaksi Terkini</h2>
            <a href="{{ route('transactions.index') }}" class="text-xs font-bold text-[#4ABDAC] hover:text-[#3ca092] inline-flex items-center gap-1 transition">
                <span>Lihat Semua</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs sm:text-sm">
                <thead class="text-xs uppercase bg-slate-50/80 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800 font-bold">
                    <tr>
                        <th class="py-3 px-4 sm:px-6 whitespace-nowrap">Tanggal</th>
                        <th class="py-3 px-4 sm:px-6">Kategori</th>
                        <th class="py-3 px-4 sm:px-6">Deskripsi</th>
                        <th class="py-3 px-4 sm:px-6 text-right whitespace-nowrap">Nominal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($recentTransactions ?? [] as $tx)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="py-3.5 px-4 sm:px-6 text-xs text-slate-500 dark:text-slate-400 whitespace-nowrap font-medium">
                                {{ $tx->transaction_date ? $tx->transaction_date->format('d M Y') : '-' }}
                            </td>
                            <td class="py-3.5 px-4 sm:px-6">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $tx->category?->color ?? '#64748b' }}"></span>
                                    <span class="truncate max-w-[120px]">{{ $tx->category?->name ?? 'Umum' }}</span>
                                </span>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-slate-800 dark:text-slate-200 font-medium max-w-xs truncate">
                                {{ $tx->description ?: '-' }}
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-right font-bold whitespace-nowrap {{ $tx->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                {{ $tx->type === 'income' ? '+' : '-' }} {{ $tx->formatted_amount ?? ('Rp ' . number_format($tx->amount, 0, ',', '.')) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-8 text-slate-400 dark:text-slate-500 text-xs">
                                Belum ada transaksi yang tercatat. Klik <a href="{{ route('transactions.create') }}" class="text-[#4ABDAC] underline font-semibold">Catat Transaksi</a> untuk memulai!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const monthlyLabels = @json($monthlyChartLabels ?? []);
        const monthlyIncome = @json($monthlyIncomeData ?? []);
        const monthlyExpense = @json($monthlyExpenseData ?? []);
        const rawCategoryData = @json($categoryBreakdown ?? []);

        const labels = monthlyLabels.length ? monthlyLabels : ['Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt'];
        const incomeData = monthlyIncome.length ? monthlyIncome : [120000, 150000, 180000, 160000, 210000, 155000];
        const expenseData = monthlyExpense.length ? monthlyExpense : [80000, 95000, 110000, 90000, 130000, 60000];

        // 1. TREN ARUS KAS
        const trendCtx = document.getElementById('cashflowTrendChart').getContext('2d');
        const gradientIncome = trendCtx.createLinearGradient(0, 0, 0, 260);
        gradientIncome.addColorStop(0, 'rgba(74, 189, 172, 0.40)');
        gradientIncome.addColorStop(1, 'rgba(74, 189, 172, 0.02)');

        const gradientExpense = trendCtx.createLinearGradient(0, 0, 0, 260);
        gradientExpense.addColorStop(0, 'rgba(252, 74, 26, 0.30)');
        gradientExpense.addColorStop(1, 'rgba(252, 74, 26, 0.02)');

        const isDark = document.documentElement.classList.contains('dark');
        const gridColor = isDark ? '#1e293b' : '#f1f5f9';
        const tickColor = isDark ? '#64748b' : '#94a3b8';

        window.trendChart = new Chart(trendCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Pemasukan (M)',
                        data: incomeData,
                        borderColor: '#4ABDAC',
                        borderWidth: 2.5,
                        fill: true,
                        backgroundColor: gradientIncome,
                        tension: 0.42,
                        pointRadius: 3,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#4ABDAC',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    },
                    {
                        label: 'Pengeluaran (K)',
                        data: expenseData,
                        borderColor: '#FC4A1A',
                        borderWidth: 2,
                        fill: true,
                        backgroundColor: gradientExpense,
                        tension: 0.42,
                        pointRadius: 3,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#FC4A1A',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { family: 'Plus Jakarta Sans', size: 12, weight: 'bold' },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 12 },
                        padding: 10,
                        cornerRadius: 10,
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: tickColor, font: { family: 'Plus Jakarta Sans', size: 11 } }
                    },
                    y: {
                        grid: { color: gridColor, drawBorder: false },
                        ticks: {
                            color: tickColor,
                            font: { family: 'Plus Jakarta Sans', size: 10 },
                            callback: function(val) { return 'Rp ' + (val >= 1000 ? (val / 1000) + 'k' : val); }
                        }
                    }
                }
            }
        });

        // 2. DONUT KATEGORI
        const donutCtx = document.getElementById('categoryDonutChart').getContext('2d');
        let donutLabels = [];
        let donutValues = [];
        let donutColors = [];

        if (rawCategoryData && rawCategoryData.length > 0) {
            donutLabels = rawCategoryData.map(item => item.name);
            donutValues = rawCategoryData.map(item => item.amount);
            donutColors = rawCategoryData.map(item => item.color || '#4ABDAC');
        } else {
            donutLabels = ['Makanan & Minuman', 'Transportasi', 'Tagihan & Listrik', 'Belanja', 'Lainnya'];
            donutValues = [40, 25, 15, 12, 8];
            donutColors = ['#4ABDAC', '#F7B733', '#FC4A1A', '#8b5cf6', '#94a3b8'];
        }

        window.donutChart = new Chart(donutCtx, {
            type: 'doughnut',
            data: {
                labels: donutLabels,
                datasets: [{
                    data: donutValues,
                    backgroundColor: donutColors,
                    borderWidth: 2,
                    borderColor: isDark ? '#0f172a' : '#ffffff',
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '68%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { family: 'Plus Jakarta Sans', size: 11, weight: 'bold' },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 11 },
                        padding: 8,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                return context.label + ': ' + (typeof value === 'number' && value > 100 ? 'Rp ' + new Intl.NumberFormat('id-ID').format(value) : value + '%');
                            }
                        }
                    }
                }
            }
        });

        // Function called when theme changes
        window.updateChartsTheme = function(isDarkTheme) {
            const newGridColor = isDarkTheme ? '#1e293b' : '#f1f5f9';
            const newTickColor = isDarkTheme ? '#64748b' : '#94a3b8';
            if (window.trendChart) {
                window.trendChart.options.scales.x.ticks.color = newTickColor;
                window.trendChart.options.scales.y.ticks.color = newTickColor;
                window.trendChart.options.scales.y.grid.color = newGridColor;
                window.trendChart.update();
            }
            if (window.donutChart) {
                window.donutChart.data.datasets[0].borderColor = isDarkTheme ? '#0f172a' : '#ffffff';
                window.donutChart.update();
            }
        };
    });
</script>
@endpush
