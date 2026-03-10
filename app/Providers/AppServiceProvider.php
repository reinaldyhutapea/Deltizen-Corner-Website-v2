<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Models\Order;
// use App\Observers\OrderObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Cek apakah visitor_id sudah ada di session, jika belum buat yang baru
        // Order::observe(OrderObserver::class);
        if (!session()->has('visitor_id')) {
            session(['visitor_id' => uniqid('visitor_', true)]);
        }
    }
}