<?php

namespace Railken\Amethyst\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Railken\Amethyst\Api\Support\Router;
use Railken\Amethyst\Common\CommonServiceProvider;
use Railken\Amethyst\Managers\FileManager;
use Railken\Amethyst\Models\File;

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
        $this->app->register(\Railken\Amethyst\Providers\TaxonomyServiceProvider::class);

        Config::set('amethyst.taxonomy.data.taxonomable.attributes.taxonomable.options.'.File::class, FileManager::class);
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
