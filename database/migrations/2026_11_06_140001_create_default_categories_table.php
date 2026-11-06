<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var list<array{name: string, type: string, color: string, icon: string}>
     */
    private array $seedCategories = [
        ['name' => 'Gaji Bulanan', 'type' => 'income', 'color' => '#10b981', 'icon' => 'wallet'],
        ['name' => 'Bonus & THR', 'type' => 'income', 'color' => '#06b6d4', 'icon' => 'gift'],
        ['name' => 'Investasi & Usaha', 'type' => 'income', 'color' => '#8b5cf6', 'icon' => 'trending-up'],
        ['name' => 'Makanan & Minuman', 'type' => 'expense', 'color' => '#ef4444', 'icon' => 'utensils'],
        ['name' => 'Transportasi & Bensin', 'type' => 'expense', 'color' => '#f97316', 'icon' => 'car'],
        ['name' => 'Belanja & Hiburan', 'type' => 'expense', 'color' => '#ec4899', 'icon' => 'shopping-bag'],
        ['name' => 'Tagihan & Listrik', 'type' => 'expense', 'color' => '#64748b', 'icon' => 'zap'],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('default_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // 'income' atau 'expense'
            $table->string('color', 30)->default('#10b981');
            $table->string('icon', 50)->default('tag');
            $table->timestamps();

            $table->index('type');
        });

        $now = now();
        foreach ($this->seedCategories as $cat) {
            DB::table('default_categories')->insert([
                'name' => $cat['name'],
                'type' => $cat['type'],
                'color' => $cat['color'],
                'icon' => $cat['icon'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_categories');
    }
};

