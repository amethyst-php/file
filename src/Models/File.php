<?php

namespace Railken\Amethyst\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Railken\Amethyst\Common\ConfigurableModel;
use Railken\Lem\Contracts\EntityContract;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * @property \Spatie\MediaLibrary\Models\Media $media
 */
class File extends Model implements EntityContract, HasMedia
{
    use HasMediaTrait, ConfigurableModel;

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->ini('amethyst.file.data.file');
        parent::__construct($attributes);
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
              ->width(368)
              ->height(232)
              ->sharpen(10);
    }

    /**
     * @return MorphTo
     */
    public function model()
    {
        return $this->morphTo();
    }

    /*
     * Get the full url to a original media file.
     *
     * @param string $name
     *
     * @return string
     */
    public function getFullUrl(string $name = '')
    {
        return $this->media[0]->getFullUrl($name);
    }
}
