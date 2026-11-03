<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FinancialAssistantContext
{
    /**
     * Susun ringkasan keuangan pengguna sebagai konteks untuk asisten AI.
     *
     * @return array{summary: array<string, float|int|string>, expense_categories: array<int, array{name: string, total: float, percentage: float}>, income_categories: array<int, array{name: string, total: float, percentage: float}>, recent_transactions: array<int, array<string, mixed>>, recent_count: int}
     */
    public function build(User $user): array
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth()->toDateString();
        $endOfMonth = $now->copy()->endOfMonth()->toDateString();

        $allIncome = (float) $user->transactions()->income()->sum('amount');
        $allExpense = (float) $user->transactions()->expense()->sum('amount');

        $thisMonthIncome = (float) $user->transactions()->income()
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $thisMonthExpense = (float) $user->transactions()->expense()
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        return [
            'summary' => [
                'tanggal_hari_ini' => $now->translatedFormat('d F Y'),
                'saldo_total' => $allIncome - $allExpense,
                'pemasukan_bulan_ini' => $thisMonthIncome,
                'pengeluaran_bulan_ini' => $thisMonthExpense,
                'arus_kas_bersih_bulan_ini' => $thisMonthIncome - $thisMonthExpense,
                'total_transaksi' => $user->transactions()->count(),
                'jumlah_kategori' => $user->categories()->count(),
            ],
            'expense_categories' => $this->categoryBreakdown($user, 'expense', $startOfMonth, $endOfMonth, $thisMonthExpense),
            'income_categories' => $this->categoryBreakdown($user, 'income', $startOfMonth, $endOfMonth, $thisMonthIncome),
            'recent_transactions' => $this->recentTransactions($user),
            'recent_count' => $user->transactions()->count(),
        ];
    }

    /**
     * Ringkasan keuangan dalam teks ringkas untuk disisipkan ke prompt.
     */
    public function toPrompt(User $user): string
    {
        $context = $this->build($user);
        $summary = $context['summary'];

        $rupiah = fn (float $value): string => 'Rp '.number_format($value, 0, ',', '.');

        $lines = [
            'Tanggal hari ini: '.$summary['tanggal_hari_ini'],
            'Saldo total: '.$rupiah((float) $summary['saldo_total']),
            'Pemasukan bulan ini: '.$rupiah((float) $summary['pemasukan_bulan_ini']),
            'Pengeluaran bulan ini: '.$rupiah((float) $summary['pengeluaran_bulan_ini']),
            'Arus kas bersih bulan ini: '.$rupiah((float) $summary['arus_kas_bersih_bulan_ini']),
            'Total transaksi tercatat: '.$summary['total_transaksi'],
            'Jumlah kategori: '.$summary['jumlah_kategori'],
        ];

        if ($context['expense_categories'] !== []) {
            $items = collect($context['expense_categories'])
                ->map(fn (array $item): string => sprintf('%s %s (%.1f%%)', $item['name'], $rupiah($item['total']), $item['percentage']))
                ->implode('; ');
            $lines[] = 'Pengeluaran per kategori bulan ini: '.$items;
        }

        if ($context['income_categories'] !== []) {
            $items = collect($context['income_categories'])
                ->map(fn (array $item): string => sprintf('%s %s (%.1f%%)', $item['name'], $rupiah($item['total']), $item['percentage']))
                ->implode('; ');
            $lines[] = 'Pemasukan per kategori bulan ini: '.$items;
        }

        if ($context['recent_transactions'] !== []) {
            $items = collect($context['recent_transactions'])
                ->map(fn (array $item): string => sprintf(
                    '%s | %s | %s | %s',
                    $item['date'],
                    $item['type'] === 'income' ? 'Pemasukan' : 'Pengeluaran',
                    $rupiah((float) $item['amount']),
                    $item['description'] !== '' ? $item['description'] : '-'
                ))
                ->implode('; ');
            $lines[] = '5 transaksi terakhir: '.$items;
        }

        return implode("\n", $lines);
    }

    /**
     * @return array<int, array{name: string, total: float, percentage: float}>
     */
    private function categoryBreakdown(User $user, string $type, string $start, string $end, float $grandTotal): array
    {
        return $user->transactions()
            ->select('category_id', DB::raw('SUM(amount) as total_amount'))
            ->where('type', $type)
            ->whereBetween('transaction_date', [$start, $end])
            ->groupBy('category_id')
            ->with('category')
            ->get()
            ->map(fn (Transaction $item): array => [
                'name' => $item->category?->name ?? 'Lainnya / Umum',
                'total' => (float) $item->total_amount,
                'percentage' => $grandTotal > 0 ? round(((float) $item->total_amount / $grandTotal) * 100, 1) : 0.0,
            ])
            ->sortByDesc('total')
            ->values()
            ->all();
    }

    /**
     * @return array<int, array{date: string, type: string, amount: float, description: string}>
     */
    private function recentTransactions(User $user): array
    {
        return $user->transactions()
            ->with('category')
            ->latest('transaction_date')
            ->latest('id')
            ->take(5)
            ->get()
            ->map(fn (Transaction $transaction): array => [
                'date' => $transaction->transaction_date?->format('Y-m-d') ?? '-',
                'type' => $transaction->type,
                'amount' => (float) $transaction->amount,
                'description' => (string) ($transaction->description ?? ''),
            ])
            ->all();
    }
}
