<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Transaksi;                 // <-- Import Model
use App\Observers\TransaksiObserver;     // <-- Import Observer

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Transaksi::observe(TransaksiObserver::class); // <-- Daftarkan
    }
}