<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    |
    | Here you can change the table name and the class components.
    |
    */
    'data' => [
        'file' => [
            'table'      => 'amethyst_files',
            'comment'    => 'File',
            'model'      => Railken\Amethyst\Models\File::class,
            'schema'     => Railken\Amethyst\Schemas\FileSchema::class,
            'repository' => Railken\Amethyst\Repositories\FileRepository::class,
            'serializer' => Railken\Amethyst\Serializers\FileSerializer::class,
            'validator'  => Railken\Amethyst\Validators\FileValidator::class,
            'authorizer' => Railken\Amethyst\Authorizers\FileAuthorizer::class,
            'faker'      => Railken\Amethyst\Fakers\FileFaker::class,
            'manager'    => Railken\Amethyst\Managers\FileManager::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Http configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the routes
    |
    */
    'http' => [
        'admin' => [
            'file' => [
                'enabled'    => true,
                'controller' => Railken\Amethyst\Http\Controllers\Admin\FilesController::class,
                'router'     => [
                    'as'     => 'file.',
                    'prefix' => '/files',
                ],
            ],
        ],
    ],
];
