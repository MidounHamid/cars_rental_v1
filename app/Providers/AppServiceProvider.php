<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

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
        // Set custom pagination view as default
        Paginator::defaultView('vendor.pagination.custom');
        Paginator::defaultSimpleView('vendor.pagination.simple-custom');

        // Register profile-layout component
        Blade::component('layouts.profile-layout', 'profile-layout');

        // Set up localization - only use supported languages for Pluralizer
    Pluralizer::useLanguage('english');
    Pluralizer::useLanguage('french');

    // ✅ Fix locale setting
    $locale = Session::get('locale', config('app.locale'));
    App::setLocale($locale);
    }
}
