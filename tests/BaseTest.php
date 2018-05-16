<?php

namespace Railken\LaraOre\File\Tests;

use Illuminate\Support\Facades\File;

abstract class BaseTest extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Laravel\Passport\PassportServiceProvider::class,
            \Railken\Laravel\Manager\ManagerServiceProvider::class,
            \Railken\Laravel\App\AppServiceProvider::class,
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

        /*File::cleanDirectory(database_path("migrations/"));

        $this->artisan('vendor:publish', [
            '--provider' => 'Railken\LaraOre\Disk\DiskServiceProvider',
            '--tag' => 'migrations'
        ]);
        $this->artisan('vendor:publish', [
            '--provider' => 'Railken\LaraOre\Disk\DiskServiceProvider',
            '--tag' => 'config'
        ]);*/

        $this->artisan('migrate:fresh');
        $this->artisan('migrate');
    }
}
