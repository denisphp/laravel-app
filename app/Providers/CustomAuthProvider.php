<?php

namespace App\Providers;

use App\Auth\CustomUserProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

class CustomAuthProvider extends ServiceProvider
{
    public function boot(GateContract $gate)
    {
        $this->app['auth']->provider('custom', function () {
            return new CustomUserProvider();
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}