<?php

namespace App\Providers;

use App\Auth\CustomUserProvider;
use App\Auth\TokenGuardExtended;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Auth::extend('tokenExtended', function () {
            $provider = new CustomUserProvider();
            return new TokenGuardExtended($provider, request());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
