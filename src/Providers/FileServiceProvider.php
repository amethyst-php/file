<?php

namespace Amethyst\Providers;

use Amethyst\Core\Providers\CommonServiceProvider;
use Amethyst\Http\Controllers\FilesController;
use Illuminate\Support\Arr;
use Amethyst\Core\Support\Router;
use Illuminate\Support\Facades\Config;

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

    /**
     * Load routes.
     */
    public function loadRoutes()
    {
        $config = Config::get('amethyst.file.http.app.file');

        Router::group('app', Arr::get($config, 'router'), function ($router) use ($config) {
            $controller = Arr::get($config, 'controller');
            $router->post('/upload', ['as' => 'upload', 'uses' => $controller.'@upload']);
            $router->get('/stream/{id}/{name}', ['as' => 'stream', 'uses' => $controller.'@stream']);
        });
    }
}
