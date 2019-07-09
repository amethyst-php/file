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
            'model'      => Amethyst\Models\File::class,
            'schema'     => Amethyst\Schemas\FileSchema::class,
            'repository' => Amethyst\Repositories\FileRepository::class,
            'serializer' => Amethyst\Serializers\FileSerializer::class,
            'validator'  => Amethyst\Validators\FileValidator::class,
            'authorizer' => Amethyst\Authorizers\FileAuthorizer::class,
            'faker'      => Amethyst\Fakers\FileFaker::class,
            'manager'    => Amethyst\Managers\FileManager::class,
            'attributes' => [
                'type' => [
                    'options' => [
                        'default',
                    ],
                ],
            ],
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
                'controller' => Amethyst\Http\Controllers\Admin\FilesController::class,
                'router'     => [
                    'as'     => 'file.',
                    'prefix' => '/files',
                ],
            ],
        ],
    ],
];
