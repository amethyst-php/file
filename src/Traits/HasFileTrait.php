<?php

namespace Railken\Amethyst\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasFileTrait
{
    /**
     * Set the polymorphic relation.
     *
     * @return mixed
     */
    public function files(): MorphMany
    {
        return $this->morphMany(config('amethyst.file.data.file.model'), 'model');
    }

    public function getFiles()
    {
        return $this->files;
    }
}
