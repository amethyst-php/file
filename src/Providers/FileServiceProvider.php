<?php

namespace Amethyst\Providers;

use Amethyst\Api\Support\Router;
use Amethyst\Common\CommonServiceProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

class FileServiceProvider extends CommonServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->loadExtraRoutes();

        $this->app->register(\Spatie\MediaLibrary\MediaLibraryServiceProvider::class);
    }

    /**
     * @inherit
     */
    public function boot()
    {
        parent::boot();

        app('amethyst')->pushMorphRelation('taxonomable', 'taxonomable', 'file');
    }

    /**
     * Load extras routes.
     */
    public function loadExtraRoutes()
    {
        $config = Config::get('amethyst.file.http.admin.file');
        if (Arr::get($config, 'enabled')) {
            Router::group('admin', Arr::get($config, 'router'), function ($router) use ($config) {
                $controller = Arr::get($config, 'controller');
                $router->post('/{id}/upload', ['as' => 'upload', 'uses' => $controller.'@upload']);
            });
        }
    }
}
