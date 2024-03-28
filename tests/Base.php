<?php

namespace Amethyst\Tests;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

abstract class Base extends \Orchestra\Testbench\TestCase
{
    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        File::cleanDirectory(database_path('migrations/'));

        $this->artisan('migrate:fresh');

        $this->artisan('vendor:publish', [
            '--provider' => 'Spatie\MediaLibrary\MediaLibraryServiceProvider',
            '--force'    => true,
        ]);
        $this->artisan('migrate');
        Schema::dropIfExists('foo');
        Schema::create('foo', function ($table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->timestamps();
        });

        app('amethyst')->ini();
        app('amethyst')->getDataNames();
        app('amethyst')->getDataManagers();
    }

    protected function getPackageProviders($app)
    {
        return [
            \Amethyst\Providers\FileServiceProvider::class,
            \Spatie\MediaLibrary\MediaLibraryServiceProvider::class,
        ];
    }
}
