<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Correct namespace
use Illuminate\Support\Facades\Schema;
use App\Models\ContactInfo;
use Illuminate\Support\Facades\View; // Import View Facade

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
        // Use Bootstrap 5 pagination
        Paginator::useBootstrapFive();

        // Set default string length for migrations
        Schema::defaultStringLength(191);
        View::composer('*', function ($view) {
            $view->with('contactInfo', ContactInfo::first());
        });
    }
}
