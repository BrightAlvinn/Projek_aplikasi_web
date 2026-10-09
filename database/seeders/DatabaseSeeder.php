<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Kategori Pemasukan
        Category::firstOrCreate(['name' => 'Gaji Bulanan', 'type' => 'income', 'color' => '#10b981']);
        Category::firstOrCreate(['name' => 'Bonus & THR', 'type' => 'income', 'color' => '#06b6d4']);
        Category::firstOrCreate(['name' => 'Investasi & Usaha', 'type' => 'income', 'color' => '#8b5cf6']);

        // Kategori Pengeluaran
        Category::firstOrCreate(['name' => 'Makanan & Minuman', 'type' => 'expense', 'color' => '#ef4444']);
        Category::firstOrCreate(['name' => 'Transportasi & Bensin', 'type' => 'expense', 'color' => '#f97316']);
        Category::firstOrCreate(['name' => 'Belanja & Hiburan', 'type' => 'expense', 'color' => '#ec4899']);
        Category::firstOrCreate(['name' => 'Tagihan & Listrik', 'type' => 'expense', 'color' => '#64748b']);
    }
}