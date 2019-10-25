<?php

namespace App\Providers;

use Spatie\BladeX\Facades\BladeX;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        $this->app->bind(
            'App\Payment\PaymentGateway',
            'App\Payment\Gateways\Quickpay\PaymentGateway'
        );

        Validator::extend('old_password', function ($attribute, $value, $parameters) {
            return Hash::check($value, Auth::user()->password);
        });
    }
}
