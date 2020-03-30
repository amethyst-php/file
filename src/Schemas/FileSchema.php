<?php

namespace Amethyst\Schemas;

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
                ->setRequired(true),
            // Attributes\EnumAttribute::make('type', config('amethyst.file.data.file.attributes.type.options')),
            Attributes\TextAttribute::make('path')
                ->setFillable(false)->setHidden(true),
            Attributes\TextAttribute::make('token')->setDefault(function ($entity, $attribute) {
                return $attribute->getManager()->getRepository()->generateToken();
            })->setFillable(false)->setHidden(true),
            Attributes\BooleanAttribute::make('public')->setDefault(function ($entity) {
                return false;
            }),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
        ];
    }
}
