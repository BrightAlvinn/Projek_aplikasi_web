<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Default Admin
        User::updateOrCreate(
            ['email' => 'admin@catatuang.com'],
            [
                'name' => 'admin',
                'role' => 'admin',
                'password' => Hash::make('password123'),
            ]
        );

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