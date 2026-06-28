<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\User;

class MenuBadgeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Hanya kirim ke layout utama — ini cukup
        View::composer('adminlte::page', function ($view) {
            try {
                $count = User::where('active', 0)->count();
                $view->with('userBaruCount', $count);
            } catch (\Exception $e) {
                // Jika error, abaikan
            }
        });
    }
}