<?php

namespace App\Providers;

use Spatie\BladeX\Facades\BladeX;
use Illuminate\Support\ServiceProvider;

\Spatie\NovaTranslatable\Translatable::defaultLocales(['en', 'da']);

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        BladeX::component('components.*');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
