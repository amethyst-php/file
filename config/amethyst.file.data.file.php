<?php

return [
    'table'      => 'file',
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
];
