<?php

namespace Railken\LaraOre\Http\Controllers;

use Illuminate\Http\Request;
use Railken\LaraOre\Api\Http\Controllers\RestController;
use Railken\LaraOre\Api\Http\Controllers\Traits as RestTraits;
use Railken\LaraOre\File\FileManager;

class FilesController extends RestController
{
    use RestTraits\RestIndexTrait;
    use RestTraits\RestShowTrait;
    use RestTraits\RestRemoveTrait;

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
     * Construct.
     */
    public function __construct(FileManager $manager)
    {
        $this->manager = $manager;
        $this->manager->setAgent($this->getUser());
        parent::__construct();
    }

    /**
     * Create a new instance for query.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function getQuery()
    {
        return $this->manager->repository->getQuery();
    }

    /**
     * Upload an image.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
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
