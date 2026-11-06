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
        // Paksa skema HTTPS jika diakses melalui reverse proxy Vercel atau environment production
        if (config('app.env') === 'production' || 
            (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') ||
            str_contains(request()->url(), 'vercel.app')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

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
