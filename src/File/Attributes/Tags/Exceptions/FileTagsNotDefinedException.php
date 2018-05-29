<?php

namespace Railken\LaraOre\File\Attributes\Tags\Exceptions;

use Railken\LaraOre\File\Exceptions\FileAttributeException;

class FileTagsNotDefinedException extends FileAttributeException
{
    /**
     * The reason (attribute) for which this exception is thrown.
     *
     * @var string
     */
    protected $attribute = 'tags';

    /**
     * The code to identify the error.
     *
     * @var string
     */
    protected $code = 'FILE_TAGS_NOT_DEFINED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is required';
}
