<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ContactRepositoryInterface;
use App\Repositories\EloquentContactRepository;
use App\Services\ContactServiceInterface;
use App\Services\ContactService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Repositório
        $this->app->bind(
            ContactRepositoryInterface::class,
            EloquentContactRepository::class
        );

        // Service
        $this->app->bind(
            ContactServiceInterface::class,
            ContactService::class
        );
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
