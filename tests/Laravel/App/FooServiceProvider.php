<?php

namespace Railken\LaraOre\File\Tests\Laravel\App;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class FooServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        if (!class_exists('CreateFooTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_foo_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_foo_table.php'),
            ], 'migrations');
        }
    }
}
