<?php

namespace Railken\Amethyst\Serializers;

use Illuminate\Support\Collection;
use Railken\Lem\Contracts\EntityContract;
use Railken\Lem\Serializer;

class FileSerializer extends Serializer
{
    /**
     * Serialize entity.
     *
     * @param \Railken\Lem\Contracts\EntityContract $entity
     * @param \Illuminate\Support\Collection        $select
     *
     * @return \Railken\Bag
     */
    public function serialize(EntityContract $entity, Collection $select = null)
    {
        $bag = parent::serialize($entity, $select);
        $bag->set('url', $entity->getFullUrl());
        $bag->set('media', $entity->media->count() > 0 ? $entity->media[0]->toArray() : null);

        if ($bag->get('media')) {
            $bag->set('conversions', collect($entity->media[0]->getMediaConversionNames())->map(function ($conversionName) use ($entity) {
                $url = $entity->getFullUrl($conversionName);

                return [
                    'name' => basename($url),
                    'url'  => $url,
                ];
            }));
        }

        return $bag;
    }
}
