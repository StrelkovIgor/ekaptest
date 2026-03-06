<?php

namespace App\Providers;

use App\Contracts\OrderServiceContract;
use App\Services\OrderService;
use Illuminate\Support\ServiceProvider;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OrderServiceContract::class, OrderService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
