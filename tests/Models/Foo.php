<?php

namespace Railken\LaraOre\File\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;

class Foo extends Model implements HasMedia
{
    use HasMediaTrait;

}
