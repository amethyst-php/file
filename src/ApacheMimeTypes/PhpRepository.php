<?php

namespace Amethyst\ApacheMimeTypes;

class PhpRepository extends \Dflydev\ApacheMimeTypes\PhpRepository
{
    public function addExtension(string $key, array $value)
    {
        $currentExtensions = isset($this->typeToExtensions[$key]) ? $this->typeToExtensions[$key] : [];

        $this->typeToExtensions[$key] = array_merge($value, $currentExtensions);
    }
}
