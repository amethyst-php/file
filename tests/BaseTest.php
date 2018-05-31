<?php

namespace Railken\LaraOre\File\Tests;

use Illuminate\Support\Facades\File;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Railken\LaraOre\FileServiceProvider::class,
            \Railken\LaraOre\File\Tests\Laravel\App\FooServiceProvider::class,
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

        File::cleanDirectory(database_path("migrations/"));

        $this->artisan('vendor:publish', [
            '--provider' => 'Spatie\MediaLibrary\MediaLibraryServiceProvider',
            '--force' => true
        ]);

        $this->artisan('vendor:publish', [
            '--provider' => 'Railken\LaraOre\FileServiceProvider',
            '--force' => true
        ]);

        $this->artisan('vendor:publish', [
            '--provider' => 'Railken\LaraOre\File\Tests\Laravel\App\FooServiceProvider',
        ]);

        $this->artisan('migrate:fresh');
        $this->artisan('migrate');
    }
}
