<?php

namespace App\Http\Controllers;

use App\Models\DefaultCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminDefaultCategoryController extends Controller
{
    /**
     * Menyimpan master template kategori default baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:income,expense'],
            'color' => ['nullable', 'string', 'max:30'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        if (empty($validated['color'])) {
            $validated['color'] = $validated['type'] === 'income' ? '#10b981' : '#ef4444';
        }

        if (empty($validated['icon'])) {
            $validated['icon'] = 'tag';
        }

        DefaultCategory::create($validated);

        return back()->with('success', "Template kategori \"{$validated['name']}\" berhasil ditambahkan ke daftar bawaan!");
    }

    /**
     * Memperbarui master template kategori default.
     */
    public function update(Request $request, DefaultCategory $defaultCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:income,expense'],
            'color' => ['nullable', 'string', 'max:30'],
            'icon' => ['nullable', 'string', 'max:50'],
        ]);

        if (empty($validated['color'])) {
            $validated['color'] = $validated['type'] === 'income' ? '#10b981' : '#ef4444';
        }

        if (empty($validated['icon'])) {
            $validated['icon'] = 'tag';
        }

        $defaultCategory->update($validated);

        return back()->with('success', "Template kategori \"{$defaultCategory->name}\" berhasil diperbarui!");
    }

    /**
     * Menghapus master template kategori default.
     */
    public function destroy(DefaultCategory $defaultCategory): RedirectResponse
    {
        $name = $defaultCategory->name;
        $defaultCategory->delete();

        return back()->with('success', "Template kategori \"{$name}\" berhasil dihapus.");
    }
}

