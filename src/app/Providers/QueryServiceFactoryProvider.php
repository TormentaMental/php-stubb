<?php

namespace App\Providers;

use App\Services\QueryService;
use Illuminate\Support\ServiceProvider;

class QueryServiceFactoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(QueryService::class, function($app) {
            return new QueryService($app->request, $app->config);
        });
    }
}
