<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Tampilkan riwayat semua transaksi.
     */
    public function index(Request $request): View
    {
        $query = Transaction::with('category')->latest('transaction_date')->latest('id');

        // Filter tipe (income / expense)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter tanggal
        if ($request->filled('date')) {
            $query->whereDate('transaction_date', $request->date);
        }

        // Filter pencarian keterangan
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->paginate(15)->withQueryString();
        $categories = Category::all();

        return view('transactions.index', compact('transactions', 'categories'));
    }

    /**
     * Ekspor data transaksi ke format CSV.
     */
    public function exportCsv(Request $request)
    {
        $query = Transaction::with('category')->latest('transaction_date')->latest('id');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('date')) {
            $query->whereDate('transaction_date', $request->date);
        }
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="transaksi_catatuang_' . date('Ymd_His') . '.csv"',
        ];

        $callback = function () use ($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Tanggal', 'Tipe', 'Kategori', 'Deskripsi', 'Nominal', 'Catatan']);

            foreach ($transactions as $t) {
                fputcsv($file, [
                    $t->id,
                    $t->transaction_date ? $t->transaction_date->format('Y-m-d') : '',
                    $t->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
                    $t->category?->name ?? 'Umum',
                    $t->description,
                    $t->amount,
                    $t->notes ?? '',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Tampilkan form catat transaksi baru.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('transactions.create', compact('categories'));
    }

    /**
     * Simpan transaksi baru ke database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:income,expense'],
            'amount' => ['required', 'numeric', 'min:1'],
            'category_id' => ['required', 'exists:categories,id'],
            'transaction_date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        Transaction::create($validated);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil disimpan!');
    }

    /**
     * Tampilkan form edit transaksi.
     */
    public function edit(Transaction $transaction): View
    {
        $categories = Category::all();
        return view('transactions.edit', compact('transaction', 'categories'));
    }

    /**
     * Simpan update perubahan transaksi.
     */
    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $validated = $request->validate([
            'type' => ['required', 'in:income,expense'],
            'amount' => ['required', 'numeric', 'min:1'],
            'category_id' => ['required', 'exists:categories,id'],
            'transaction_date' => ['required', 'date'],
            'description' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $transaction->update($validated);

        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    /**
     * Hapus transaksi.
     */
    public function destroy(Transaction $transaction): RedirectResponse
    {
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }
}