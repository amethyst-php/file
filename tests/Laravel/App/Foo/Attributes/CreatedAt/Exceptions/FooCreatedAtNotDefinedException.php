<?php

namespace Railken\LaraOre\File\Tests\Laravel\App\Foo\Attributes\CreatedAt\Exceptions;

use Railken\LaraOre\File\Tests\Laravel\App\Foo\Exceptions\FooAttributeException;

class FooCreatedAtNotDefinedException extends FooAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'created_at';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'FOO_CREATED_AT_NOT_DEFINED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is required';
}
