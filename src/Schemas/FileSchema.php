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
                ->setDefault(function ($entity, $attribute) {
                    return Uuid::uuid4()->toString();
                })
                ->setRequired(true),
            Attributes\EnumAttribute::make('type', config('amethyst.file.data.file.attributes.type.options')),
            Attributes\TextAttribute::make('path')
                ->setFillable(false),
            Attributes\TextAttribute::make('token')->setDefault(function ($entity, $attribute) {
                return $attribute->getManager()->getRepository()->generateToken();
            })->setFillable(false),
            Attributes\EnumAttribute::make('model_type', app('amethyst')->getDataNames()),
            Attributes\MorphToAttribute::make('model_id')
                ->setRelationKey('model_type')
                ->setRelationName('model')
                ->setRelations(app('amethyst')->getDataManagers()),
            Attributes\BooleanAttribute::make('public')->setDefault(function ($entity) {
                return false;
            }),
            Attributes\CreatedAtAttribute::make(),
            Attributes\UpdatedAtAttribute::make(),
        ];
    }
}
