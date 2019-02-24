<?php

namespace Railken\Amethyst\Schemas;

use Railken\Lem\Attributes;
use Railken\Lem\Schema;
use Ramsey\Uuid\Uuid;

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
            Attributes\TextAttribute::make('name')
                ->setDefault(function ($entity, $attribute) {
                    return Uuid::uuid4()->toString();
                })
                ->setRequired(true),
            Attributes\TextAttribute::make('path'),
            Attributes\TextAttribute::make('token')->setDefault(function ($entity, $attribute) {
                return $attribute->getManager()->getRepository()->generateToken();
            }),
            Attributes\TextAttribute::make('model_type'),
            Attributes\NumberAttribute::make('model_id'),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
        ];
    }
}
