<?php

namespace Railken\Amethyst\Authorizers;

use Railken\Lem\Authorizer;
use Railken\Lem\Tokens;

class FileAuthorizer extends Authorizer
{
    /**
     * List of all permissions.
     *
     * @var array
     */
    protected $permissions = [
        Tokens::PERMISSION_CREATE => 'file.create',
        Tokens::PERMISSION_UPDATE => 'file.update',
        Tokens::PERMISSION_SHOW   => 'file.show',
        Tokens::PERMISSION_REMOVE => 'file.remove',
    ];
}
