<?php

namespace Railken\Amethyst\Traits;

use Railken\Amethyst\Models\File;
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
        return $this->morphMany(File::class, 'model');
    }

    public function getFiles(array $tags)
    {
        $collection = $this->files->filter(function ($file) use ($tags) {
            return count(array_intersect($file->tags->map(function ($tag) {
                return $tag->tag->name;
            })->toArray(), $tags)) > 0;
        });

        return $collection;
    }
}
