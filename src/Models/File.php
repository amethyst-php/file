<?php

namespace Railken\Amethyst\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Config;
use Railken\Amethyst\Schemas\FileSchema;
use Railken\Lem\Contracts\EntityContract;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * @property \Spatie\MediaLibrary\Models\Media $media
 */
class File extends Model implements EntityContract, HasMedia
{
    use HasMediaTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'model_type',
        'model_id',
        'tags',
        'token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'tags' => 'array',
    ];

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('amethyst.file.managers.file.table');
        // $this->fillable = (new FileSchema())->getNameFillableAttributes();
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
