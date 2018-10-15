<?php

namespace Railken\Amethyst\Schemas;

use Railken\Lem\Attributes;
use Railken\Lem\Schema;

class FileSchema extends Schema
{
    /**
     * Get all the attributes.
     *
     * @var array
     */
    public function getAttributes()
    {
        return [
            Attributes\IdAttribute::make(),
            Attributes\TextAttribute::make('token')->setDefault(function ($entity, $attribute) {
                return $attribute->getManager()->getRepository()->generateToken();
            }),
            Attributes\TextAttribute::make('model_type'),
            Attributes\NumberAttribute::make('model_id'),
            Attributes\ArrayAttribute::make('tags'),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
        ];
    }
}
