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

        if (!class_exists('CreateFilesTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_files_table.php.stub' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_files_table.php'),
            ], 'migrations');
        }
    }
}
