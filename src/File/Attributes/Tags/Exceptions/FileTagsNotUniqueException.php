<?php

namespace Railken\LaraOre\File\Attributes\Tags\Exceptions;

use Railken\LaraOre\File\Exceptions\FileAttributeException;

class FileTagsNotUniqueException extends FileAttributeException
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
    protected $code = 'FILE_TAGS_NOT_UNIQUE';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = 'The %s is not unique';
}
