<?php

namespace Railken\LaraOre\File\Tests\Laravel\App\Foo;

use Illuminate\Support\ServiceProvider;

class FooServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        Foo::observe(FooObserver::class);
    }
}
