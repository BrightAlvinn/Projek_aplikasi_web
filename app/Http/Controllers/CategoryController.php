<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Tampilkan halaman Manajemen Kategori milik pengguna yang login.
     */
    public function index(Request $request): View
    {
        $expenseCategories = $request->user()->categories()
            ->expense()
            ->withCount('transactions')
            ->orderBy('name')
            ->get();

        $incomeCategories = $request->user()->categories()
            ->income()
            ->withCount('transactions')
            ->orderBy('name')
            ->get();

        return view('categories.index', compact('expenseCategories', 'incomeCategories'));
    }

    /**
     * Simpan kategori baru untuk pengguna yang login.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:income,expense'],
            'color' => ['nullable', 'string', 'max:30'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        if ($request->user()->categories()->where('name', $validated['name'])->where('type', $validated['type'])->exists()) {
            return redirect()->route('categories.index')->with('error', 'Kategori dengan nama dan jenis yang sama sudah ada.');
        }

        if (empty($validated['color'])) {
            $validated['color'] = $validated['type'] === 'income' ? '#10b981' : '#ef4444';
        }

        $request->user()->categories()->create($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Perbarui data kategori milik pengguna yang login.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $this->ensureOwnedByUser($request, $category);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:income,expense'],
            'color' => ['nullable', 'string', 'max:30'],
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Hapus kategori milik pengguna yang login.
     */
    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $this->ensureOwnedByUser($request, $category);

        if ($category->transactions()->exists()) {
            return redirect()->route('categories.index')->with('error', 'Kategori tidak dapat dihapus karena masih digunakan pada data transaksi.');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus!');
    }

    /**
     * Pastikan kategori benar-benar milik pengguna yang login.
     */
    private function ensureOwnedByUser(Request $request, Category $category): void
    {
        abort_unless($category->user_id === $request->user()->id, 404);
    }
}
