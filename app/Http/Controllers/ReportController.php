<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Tampilkan halaman Laporan & Analitik Keuangan.
     */
    public function index(Request $request): View
    {
        $now = Carbon::now();
        $selectedMonth = (int) $request->input('month', $now->month);
        $selectedYear = (int) $request->input('year', $now->year);

        $startDate = Carbon::createFromDate($selectedYear, $selectedMonth, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        $daysInMonth = $startDate->daysInMonth;

        // 1. Akumulasi Saldo Total (Keseluruhan Waktu)
        $allIncome = (float) Transaction::income()->sum('amount');
        $allExpense = (float) Transaction::expense()->sum('amount');
        $totalBalance = $allIncome - $allExpense;

        // 2. Metrik Periode Terpilih
        $periodIncome = (float) Transaction::income()
            ->whereBetween('transaction_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->sum('amount');

        $periodExpense = (float) Transaction::expense()
            ->whereBetween('transaction_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->sum('amount');

        $periodNet = $periodIncome - $periodExpense;

        // 3. Data Alur Kas Harian untuk Grafik (Hari 1 sampai Hari Terakhir)
        $dailyLabels = [];
        $dailyIncomeData = [];
        $dailyExpenseData = [];

        // Ambil transaksi harian yang diagregasi
        $dailyTransactions = Transaction::select(
                DB::raw('DATE(transaction_date) as t_date'),
                'type',
                DB::raw('SUM(amount) as total')
            )
            ->whereBetween('transaction_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->groupBy('t_date', 'type')
            ->get();

        $dailyIncomeMap = [];
        $dailyExpenseMap = [];
        foreach ($dailyTransactions as $dt) {
            $dayNum = (int) Carbon::parse($dt->t_date)->format('j');
            if ($dt->type === 'income') {
                $dailyIncomeMap[$dayNum] = (float) $dt->total;
            } else {
                $dailyExpenseMap[$dayNum] = (float) $dt->total;
            }
        }

        for ($d = 1; $d <= $daysInMonth; $d++) {
            $dailyLabels[] = 'Tgl ' . $d;
            $dailyIncomeData[] = $dailyIncomeMap[$d] ?? 0;
            $dailyExpenseData[] = $dailyExpenseMap[$d] ?? 0;
        }

        // 4. Detail Pemasukan per Kategori
        $incomeBreakdown = Transaction::query()
            ->select('category_id', DB::raw('SUM(amount) as total_amount'))
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function ($item) use ($periodIncome) {
                return [
                    'name' => $item->category?->name ?? 'Lainnya',
                    'color' => $item->category?->color ?? '#10b981',
                    'amount' => (float) $item->total_amount,
                    'percentage' => $periodIncome > 0 ? round(($item->total_amount / $periodIncome) * 100, 1) : 0,
                ];
            })
            ->sortByDesc('amount')
            ->values();

        // 5. Detail Pengeluaran per Kategori
        $expenseBreakdown = Transaction::query()
            ->select('category_id', DB::raw('SUM(amount) as total_amount'))
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startDate->toDateString(), $endDate->toDateString()])
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function ($item) use ($periodExpense) {
                return [
                    'name' => $item->category?->name ?? 'Lainnya',
                    'color' => $item->category?->color ?? '#ef4444',
                    'amount' => (float) $item->total_amount,
                    'percentage' => $periodExpense > 0 ? round(($item->total_amount / $periodExpense) * 100, 1) : 0,
                ];
            })
            ->sortByDesc('amount')
            ->values();

        // Daftar Bulan untuk Filter
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        return view('reports.index', compact(
            'selectedMonth',
            'selectedYear',
            'monthNames',
            'totalBalance',
            'periodIncome',
            'periodExpense',
            'periodNet',
            'dailyLabels',
            'dailyIncomeData',
            'dailyExpenseData',
            'incomeBreakdown',
            'expenseBreakdown'
        ));
    }
}
