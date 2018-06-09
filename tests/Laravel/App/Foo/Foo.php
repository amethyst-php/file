<?php

namespace Railken\LaraOre\File\Tests\Laravel\App\Foo;

use Illuminate\Database\Eloquent\Model;
use Railken\LaraOre\File\HasFileTrait;
use Railken\Laravel\Manager\Contracts\EntityContract;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * @method static mixed create()
 */
class Foo extends Model implements EntityContract, HasMedia
{
    use HasMediaTrait;
    use HasFileTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'foo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['created_at', 'updated_at'];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
              ->width(368)
              ->height(232)
              ->sharpen(10);
    }
}
