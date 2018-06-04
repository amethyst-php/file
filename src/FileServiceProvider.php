<?php

namespace Railken\LaraOre;

use Illuminate\Support\ServiceProvider;

class FileServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ore.file.php' => config_path('ore.file.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(\Railken\Laravel\Manager\ManagerServiceProvider::class);
        $this->app->register(\Spatie\MediaLibrary\MediaLibraryServiceProvider::class);
        $this->mergeConfigFrom(__DIR__.'/../config/ore.file.php', 'ore.file');
    }
}
