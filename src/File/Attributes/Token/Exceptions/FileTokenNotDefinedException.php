<?php

namespace Railken\LaraOre\File\Attributes\Token\Exceptions;

use Railken\LaraOre\File\Exceptions\FileAttributeException;

class FileTokenNotDefinedException extends FileAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'token';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'FILE_TOKEN_NOT_DEFINED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is required';
}
