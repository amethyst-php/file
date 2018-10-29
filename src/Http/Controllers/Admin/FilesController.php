<?php

namespace Railken\Amethyst\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Railken\Amethyst\Api\Http\Controllers\RestManagerController;
use Railken\Amethyst\Api\Http\Controllers\Traits as RestTraits;
use Railken\Amethyst\Managers\FileManager;

class FilesController extends RestManagerController
{
    use RestTraits\RestIndexTrait;
    use RestTraits\RestShowTrait;
    use RestTraits\RestUpdateTrait;
    use RestTraits\RestRemoveTrait;

    /**
     * The class of the manager.
     *
     * @var string
     */
    public $class = FileManager::class;

    /**
     * The attributes that are fillable.
     *
     * @var array
     */
    public function create(Request $request)
    {
        $result = $this->getManager()->uploadFileByContent(base64_decode($request->input('file')), $request->input('name'));

        if (!$result->ok()) {
            return $this->error(['errors' => $result->getSimpleErrors()]);
        }

        return $this->success(['data' => $this->getManager()->getSerializer()->serialize($result->getResource())->toArray()], 201);
    }
}
