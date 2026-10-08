<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\OTPInterface;
use App\Services\SMSOTPService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
         $this->app->bind(OTPInterface::class, SMSOTPService::class);
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
