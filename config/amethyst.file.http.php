<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Http configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the routes
    |
    */
    'app' => [
        'file' => [
            'enabled'    => true,
            'controller' => Amethyst\Http\Controllers\FileController::class,
            'router'     => [
                'prefix' => '/data/file',
                'as'     => 'file.upload.',
            ],
        ],
    ],
];
