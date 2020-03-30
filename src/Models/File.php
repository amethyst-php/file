<?php

namespace Amethyst\Models;

use Amethyst\Core\ConfigurableModel;
use Illuminate\Database\Eloquent\Model;
use Railken\Lem\Contracts\EntityContract;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * @property \Spatie\MediaLibrary\Models\Media $media
 * @property string                            $name
 * @property string                            $path
 */
class File extends Model implements EntityContract, HasMedia
{
    use HasMediaTrait;
    use ConfigurableModel;

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

    /**
     * Get the full url to a original media file.
     *
     * @param string $name
     * @param string $conversion
     *
     * @return string
     */
    public function getFullUrl(string $conversion = '')
    {
        if (!isset($this->media[0])) {
            return null;
        }

        $media = $this->media[0];

        if (in_array($media->disk, ['local', 'public'], true)) {
            return route('app.file.upload.stream', ['id' => $this->id, 'name' => $this->name]);
        }

        return $media->disk === 's3' && !$this->public
            ? $media->getTemporaryUrl(new \DateTime('+1 hour'), $conversion)
            : $media->getFullUrl($conversion);
    }

    /**
     * Get url downloadable.
     *
     * @return string
     */
    public function downloadable()
    {
        $media = $this->media[0];

        if (in_array($media->disk, ['local', 'public'], true)) {
            return $media->getPath();
        }

        return $media->getFullUrl();
    }
}
