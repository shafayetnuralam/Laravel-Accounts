<?php

namespace App\Providers;

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
        //
            view()->share([
            'appStartDate' => '10/04/2026',
            'appEndDate'   => date('d/m/Y'),
            'Company'      => 'Account Management Software',
            'Contact'      => '01982985490',
            'Address'      => 'Dhaka,Bangladesh',

            ]);
    }
}
