<?php

namespace Railken\LaraOre\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Railken\LaraOre\Api\Http\Controllers\RestConfigurableController;
use Railken\LaraOre\Api\Http\Controllers\Traits as RestTraits;

class FilesController extends RestConfigurableController
{
    use RestTraits\RestIndexTrait;
    use RestTraits\RestShowTrait;
    use RestTraits\RestRemoveTrait;

    /**
     * The config path.
     *
     * @var string
     */
    public $config = 'ore.file';

    /**
     * The attributes that are queryable.
     *
     * @var array
     */
    public $queryable = [
        'id',
        'model_type',
        'model_id',
        'tags',
        'token',
        'created_at',
        'updated_at',
    ];

    public $fillable = [
        'model_type',
        'model_id',
        'tags',
        'token',
    ];

    /**
     * The attributes that are fillable.
     *
     * @var array
     */
    public function upload(Request $request)
    {
        $result = $this->manager->uploadFileByContent($request->input('file'), $request->input('name'));

        if (!$result->ok()) {
            return $this->error(['errors' => $result->getSimpleErrors()]);
        }

        return $this->success(['resource' => $this->manager->serializer->serialize($result->getResource())->toArray()], 201);
    }
}
