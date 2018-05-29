<?php

namespace Railken\LaraOre\File\Attributes\Tags\Exceptions;

use Railken\LaraOre\File\Exceptions\FileAttributeException;

class FileTagsNotAuthorizedException extends FileAttributeException
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
    protected $code = 'FILE_TAGS_NOT_AUTHTORIZED';

    /**
     * The message.
     *
     * @var string
     */
    protected $message = "You're not authorized to interact with %s, missing %s permission";
}
