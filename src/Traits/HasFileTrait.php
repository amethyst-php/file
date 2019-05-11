<?php

namespace Railken\Amethyst\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Railken\Amethyst\Models\File;

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

    public function getFiles(array $tags)
    {
        $collection = $this->files->filter(function ($file) use ($tags) {
            return count(array_intersect($file->tags->map(function ($tag) {
                return $tag->taxonomy->name;
            })->toArray(), $tags)) > 0;
        });

        return $collection;
    }
}
