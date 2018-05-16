<?php

namespace Railken\LaraOre\File\Tests;

use Illuminate\Support\Facades\File;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Railken\Laravel\Manager\ManagerServiceProvider::class,
            \Railken\Laravel\App\AppServiceProvider::class,
            \Railken\LaraOre\File\Tests\Laravel\App\FooServiceProvider::class,
            \Spatie\MediaLibrary\MediaLibraryServiceProvider::class
        ];
    }

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__.'/..', '.env');
        $dotenv->load();



        parent::setUp();


        $this->artisan('vendor:publish', [
            '--provider' => 'Spatie\MediaLibrary\MediaLibraryServiceProvider',
            '--tag' => 'config'
        ]);

        File::cleanDirectory(database_path("migrations/"));

        $this->artisan('vendor:publish', [
            '--provider' => 'Railken\LaraOre\File\Tests\Laravel\App\FooServiceProvider',
            '--tag' => 'migrations'
        ]);

        $this->artisan('vendor:publish', [
            '--provider' => 'Spatie\MediaLibrary\MediaLibraryServiceProvider',
            '--tag' => 'migrations'
        ]);
        $this->artisan('migrate:fresh');
        $this->artisan('migrate');
    }
}
