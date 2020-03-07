<?php

namespace Amethyst\Providers;

use Amethyst\Core\Providers\CommonServiceProvider;
use Amethyst\Http\Controllers\FilesController;

class FileServiceProvider extends CommonServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->app->register(\Spatie\MediaLibrary\MediaLibraryServiceProvider::class);

        /*
        app('amethyst.router')->routes('file', function ($router) use ($config) {
            $controller = FilesController::class;
            $router->post('/{id}/upload', ['as' => 'upload', 'uses' => $controller.'@upload']);
            $router->post('/{id}/download', ['as' => 'download', 'uses' => $controller.'@download']);
        });
        */
    }
}
