<?php

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * @var list<array{name: string, type: string, color: string}>
     */
    private array $defaultCategories = [
        ['name' => 'Gaji Bulanan', 'type' => 'income', 'color' => '#10b981'],
        ['name' => 'Bonus & THR', 'type' => 'income', 'color' => '#06b6d4'],
        ['name' => 'Investasi & Usaha', 'type' => 'income', 'color' => '#8b5cf6'],
        ['name' => 'Makanan & Minuman', 'type' => 'expense', 'color' => '#ef4444'],
        ['name' => 'Transportasi & Bensin', 'type' => 'expense', 'color' => '#f97316'],
        ['name' => 'Belanja & Hiburan', 'type' => 'expense', 'color' => '#ec4899'],
        ['name' => 'Tagihan & Listrik', 'type' => 'expense', 'color' => '#64748b'],
    ];

    public function up(): void
    {
        if (Schema::hasColumn('transactions', 'user_id') && Schema::hasColumn('categories', 'user_id')) {
            return;
        }

        DB::transaction(function () {
            DB::table('transactions')->delete();
            DB::table('categories')->delete();

            Schema::table('transactions', function (Blueprint $table) {
                $table->dropForeign(['category_id']);
            });

            Schema::table('categories', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->cascadeOnDelete();
                $table->index(['user_id', 'type']);
            });

            Schema::table('transactions', function (Blueprint $table) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->cascadeOnDelete();
                $table->index(['user_id', 'transaction_date', 'type']);
                $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            });

            User::query()->each(function (User $user) {
                foreach ($this->defaultCategories as $category) {
                    Category::create([
                        'user_id' => $user->id,
                        'name' => $category['name'],
                        'type' => $category['type'],
                        'color' => $category['color'],
                        'icon' => 'tag',
                    ]);
                }
            });
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            DB::table('transactions')->delete();
            DB::table('categories')->delete();

            Schema::table('transactions', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropIndex(['user_id', 'transaction_date', 'type']);
                $table->dropColumn('user_id');
            });

            Schema::table('categories', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropIndex(['user_id', 'type']);
                $table->dropColumn('user_id');
            });
        });
    }
};
