<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Services\Contracts\RunService::class,
            \App\Services\RunServiceJob::class
        );
        $this->app->bind(
            \App\Services\Contracts\ParcelService::class,
            \App\Services\ParcelServiceJob::class
        );
        $this->app->bind(
            \App\Services\Contracts\UserService::class,
            \App\Services\UserServiceJob::class
        );
        $this->app->bind(
            \App\Services\Contracts\FavouriteService::class,
            \App\Services\FavouriteServiceJob::class
        );
        $this->app->bind(
            \App\Services\Contracts\OfflineService::class,
            \App\Services\OfflineServiceJob::class
        );
    }
}
