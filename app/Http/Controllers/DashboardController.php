<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menghitung seluruh metrik keuangan untuk ditampilkan di Dashboard.
     */
    public function index(): View
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth()->toDateString();
        $endOfMonth = $now->copy()->endOfMonth()->toDateString();

        // 1. Akumulasi Total Saldo (Semua Waktu)
        $allIncome = (float) Transaction::income()->sum('amount');
        $allExpense = (float) Transaction::expense()->sum('amount');
        $totalBalance = $allIncome - $allExpense;

        // 2. Metrik Bulan Berjalan
        $thisMonthIncome = (float) Transaction::income()
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $thisMonthExpense = (float) Transaction::expense()
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $thisMonthNet = $thisMonthIncome - $thisMonthExpense;

        // 3. Data Tren 6 Bulan Terakhir untuk Grafik
        $monthlyChartLabels = [];
        $monthlyIncomeData = [];
        $monthlyExpenseData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $monthStart = $date->copy()->startOfMonth()->toDateString();
            $monthEnd = $date->copy()->endOfMonth()->toDateString();

            $monthlyChartLabels[] = $date->translatedFormat('M Y');
            $monthlyIncomeData[] = (float) Transaction::income()
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');
            $monthlyExpenseData[] = (float) Transaction::expense()
                ->whereBetween('transaction_date', [$monthStart, $monthEnd])
                ->sum('amount');
        }

        // 4. Pembagian Kategori Pengeluaran Bulan Ini
        $categoryBreakdown = Transaction::query()
            ->select('category_id', DB::raw('SUM(amount) as total_amount'))
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(function ($item) use ($thisMonthExpense) {
                $percentage = $thisMonthExpense > 0 ? round(($item->total_amount / $thisMonthExpense) * 100, 1) : 0;

                return [
                    'name' => $item->category?->name ?? 'Lainnya',
                    'color' => $item->category?->color ?? '#94a3b8',
                    'amount' => (float) $item->total_amount,
                    'percentage' => $percentage,
                ];
            })
            ->sortByDesc('amount')
            ->values();

        // 5. Daftar 5 Transaksi Terakhir
        $recentTransactions = Transaction::with('category')
            ->latest('transaction_date')
            ->latest('id')
            ->take(5)
            ->get();

        $totalTransactionsCount = Transaction::count();

        return view('dashboard', [
            'totalBalance' => $totalBalance,
            'thisMonthIncome' => $thisMonthIncome,
            'thisMonthExpense' => $thisMonthExpense,
            'thisMonthNet' => $thisMonthNet,
            'monthlyChartLabels' => $monthlyChartLabels,
            'monthlyIncomeData' => $monthlyIncomeData,
            'monthlyExpenseData' => $monthlyExpenseData,
            'categoryBreakdown' => $categoryBreakdown,
            'recentTransactions' => $recentTransactions,
            'totalTransactionsCount' => $totalTransactionsCount,
        ]);
    }
}
