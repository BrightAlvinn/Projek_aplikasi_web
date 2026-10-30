<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Transaction::creating(function (Transaction $transaction): void {
            if ($transaction->user_id === null) {
                $transaction->user_id = Auth::id();
            }

            if ($transaction->user_id === null) {
                throw new \RuntimeException('Transaksi tidak boleh disimpan tanpa user_id.');
            }
        });

        Category::creating(function (Category $category): void {
            if ($category->user_id === null) {
                $category->user_id = Auth::id();
            }

            if ($category->user_id === null) {
                throw new \RuntimeException('Kategori tidak boleh disimpan tanpa user_id.');
            }
        });
    }
}
