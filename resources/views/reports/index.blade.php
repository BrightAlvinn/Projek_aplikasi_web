@extends('layouts.app')

@section('title', 'Laporan & Analitik Keuangan')
@section('page_title', 'Laporan & Analitik Keuangan')

@section('content')

    <!-- WIREFRAME TOP CONTROL BAR: FILTER BULAN & TAHUN + CETAK PDF -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-5 transition-colors no-print">
        <form method="GET" action="{{ route('reports.index') }}" class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
            
            <!-- Filter Dropdowns: Bulan & Tahun -->
            <div class="flex flex-wrap items-center gap-3">
                <!-- Dropdown Bulan -->
                <div class="min-w-[140px]">
                    <select name="month" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                        @foreach($monthNames as $num => $name)
                            <option value="{{ $num }}" {{ $selectedMonth == $num ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Dropdown Tahun -->
                <div class="min-w-[100px]">
                    <select name="year" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#4ABDAC] transition">
                        @for($y = 2024; $y <= 2028; $y++)
                            <option value="{{ $y }}" {{ $selectedYear == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Tombol Tampilkan Laporan -->
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-slate-700 text-white text-xs sm:text-sm font-bold shadow-xs transition inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <span>Tampilkan Laporan</span>
                </button>
            </div>

            <!-- Tombol Cetak / Simpan PDF -->
            <div class="flex items-center justify-end">
                <button type="button" onclick="window.print()" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-[#4ABDAC] hover:bg-[#3ca092] text-white text-xs sm:text-sm font-bold shadow-md shadow-[#4ABDAC]/20 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    <span>Cetak / Simpan PDF</span>
                </button>
            </div>

        </form>
    </div>


    <!-- WIREFRAME SUMMARY SECTION: 4 MINI CARDS METRIK -->
    <div class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-extrabold text-slate-900 dark:text-white uppercase tracking-wider">
                Ringkasan Laporan: {{ $monthNames[$selectedMonth] ?? '' }} {{ $selectedYear }}
            </h2>
            <span class="text-xs text-slate-400 dark:text-slate-500">Mata Uang: IDR (Rp)</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Saldo Total -->
            <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs">
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block mb-1">Saldo</span>
                <p class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                    Rp {{ number_format($totalBalance, 0, ',', '.') }}
                </p>
                <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Akumulasi keseluruhan</p>
            </div>

            <!-- Pemasukan Periode -->
            <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs">
                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 block mb-1">Pemasukan Bulan ini</span>
                <p class="text-xl sm:text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 tracking-tight">
                    Rp {{ number_format($periodIncome, 0, ',', '.') }}
                </p>
                <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Total arus masuk</p>
            </div>

            <!-- Pengeluaran Periode -->
            <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs">
                <span class="text-xs font-bold text-rose-600 dark:text-rose-400 block mb-1">Pengeluaran Bulan ini</span>
                <p class="text-xl sm:text-2xl font-extrabold text-rose-600 dark:text-rose-400 tracking-tight">
                    Rp {{ number_format($periodExpense, 0, ',', '.') }}
                </p>
                <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Total arus keluar</p>
            </div>

            <!-- Arus Kas Net -->
            <div class="bg-white dark:bg-slate-900 p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs">
                <span class="text-xs font-bold text-[#4ABDAC] block mb-1">Arus Kas Net</span>
                <p class="text-xl sm:text-2xl font-extrabold {{ $periodNet >= 0 ? 'text-[#4ABDAC]' : 'text-rose-600 dark:text-rose-400' }} tracking-tight">
                    Rp {{ number_format($periodNet, 0, ',', '.') }}
                </p>
                <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Surplus bersih periode</p>
            </div>
        </div>
    </div>


    <!-- WIREFRAME LARGE CHART: GRAFIK ALUR KAS HARIAN -->
    <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs space-y-4 transition-colors">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-3">
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white tracking-tight">Grafik Alur Kas Harian</h3>
                <p class="text-[11px] text-slate-400 dark:text-slate-500">Visualisasi arus kas masuk dan keluar per hari selama bulan {{ $monthNames[$selectedMonth] }} {{ $selectedYear }}</p>
            </div>
            <div class="flex items-center gap-4 text-xs font-bold">
                <span class="inline-flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400">
                    <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                    <span>Pemasukan</span>
                </span>
                <span class="inline-flex items-center gap-1.5 text-rose-600 dark:text-rose-400">
                    <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                    <span>Pengeluaran</span>
                </span>
            </div>
        </div>

        <div class="relative w-full h-72 sm:h-80">
            <canvas id="dailyCashflowChart"></canvas>
        </div>
    </div>


    <!-- WIREFRAME BOTTOM 2 CARDS: DETAIL PER KATEGORI -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        
        <!-- CARD 1: DETAIL PEMASUKAN PER KATEGORI -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-5 transition-colors">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">Detail Pemasukan per Kategori</h3>
                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">Total: Rp {{ number_format($periodIncome, 0, ',', '.') }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="uppercase bg-slate-50 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-100 dark:border-slate-800">
                        <tr>
                            <th class="py-2.5 px-3">Kategori</th>
                            <th class="py-2.5 px-3 text-right">Nominal</th>
                            <th class="py-2.5 px-3 text-right">Porsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($incomeBreakdown as $ib)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                                <td class="py-3 px-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $ib['color'] }}"></span>
                                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ $ib['name'] }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-3 text-right font-extrabold text-emerald-600 dark:text-emerald-400 whitespace-nowrap">
                                    Rp {{ number_format($ib['amount'], 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-3 text-right font-bold text-slate-700 dark:text-slate-300">
                                    {{ $ib['percentage'] }}%
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-slate-400 dark:text-slate-500">
                                    Belum ada data pemasukan pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- CARD 2: DETAIL PENGELUARAN PER KATEGORI -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs p-5 transition-colors">
            <div class="flex items-center justify-between pb-3 mb-3 border-b border-slate-100 dark:border-slate-800">
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">Detail Pengeluaran per Kategori</h3>
                <span class="text-xs font-bold text-rose-600 dark:text-rose-400">Total: Rp {{ number_format($periodExpense, 0, ',', '.') }}</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="uppercase bg-slate-50 dark:bg-slate-800/60 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-100 dark:border-slate-800">
                        <tr>
                            <th class="py-2.5 px-3">Kategori</th>
                            <th class="py-2.5 px-3 text-right">Nominal</th>
                            <th class="py-2.5 px-3 text-right">Porsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($expenseBreakdown as $eb)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                                <td class="py-3 px-3">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full shrink-0" style="background-color: {{ $eb['color'] }}"></span>
                                        <span class="font-bold text-slate-800 dark:text-slate-200">{{ $eb['name'] }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-3 text-right font-extrabold text-rose-600 dark:text-rose-400 whitespace-nowrap">
                                    Rp {{ number_format($eb['amount'], 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-3 text-right font-bold text-slate-700 dark:text-slate-300">
                                    {{ $eb['percentage'] }}%
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-slate-400 dark:text-slate-500">
                                    Belum ada data pengeluaran pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dailyLabels = @json($dailyLabels ?? []);
        const dailyIncome = @json($dailyIncomeData ?? []);
        const dailyExpense = @json($dailyExpenseData ?? []);

        const ctx = document.getElementById('dailyCashflowChart').getContext('2d');
        const isDark = document.documentElement.classList.contains('dark');
        const gridColor = isDark ? '#1e293b' : '#f1f5f9';
        const tickColor = isDark ? '#64748b' : '#94a3b8';

        window.dailyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: dailyLabels,
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: dailyIncome,
                        backgroundColor: '#10b981',
                        borderRadius: 6,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8
                    },
                    {
                        label: 'Pengeluaran',
                        data: dailyExpense,
                        backgroundColor: '#ef4444',
                        borderRadius: 6,
                        barPercentage: 0.7,
                        categoryPercentage: 0.8
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
                        ticks: { color: tickColor, font: { family: 'Plus Jakarta Sans', size: 10 } }
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

        window.updateChartsTheme = function(isDarkTheme) {
            const newGridColor = isDarkTheme ? '#1e293b' : '#f1f5f9';
            const newTickColor = isDarkTheme ? '#64748b' : '#94a3b8';
            if (window.dailyChart) {
                window.dailyChart.options.scales.x.ticks.color = newTickColor;
                window.dailyChart.options.scales.y.ticks.color = newTickColor;
                window.dailyChart.options.scales.y.grid.color = newGridColor;
                window.dailyChart.update();
            }
        };
    });
</script>
@endpush
