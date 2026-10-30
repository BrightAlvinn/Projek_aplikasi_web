<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $orphans = DB::table('transactions')->whereNull('user_id')->get();

        foreach ($orphans as $transaction) {
            $categoryOwner = DB::table('categories')
                ->where('id', $transaction->category_id)
                ->value('user_id');

            if ($categoryOwner === null) {
                continue;
            }

            DB::table('transactions')
                ->where('id', $transaction->id)
                ->update([
                    'user_id' => $categoryOwner,
                    'updated_at' => now(),
                ]);
        }
    }

    public function down(): void
    {
        //
    }
};
