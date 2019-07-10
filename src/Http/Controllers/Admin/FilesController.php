<?php

namespace Amethyst\Http\Controllers\Admin;

use Amethyst\Api\Http\Controllers\RestManagerController;
use Amethyst\Api\Http\Controllers\Traits as RestTraits;
use Amethyst\Managers\FileManager;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \Amethyst\Managers\FileManager getManager()
 */
class FilesController extends RestManagerController
{
    use RestTraits\RestIndexTrait;
    use RestTraits\RestCreateTrait;
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
     * @param mixed   $id
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function upload($id, Request $request)
    {
        $entity = $this->getEntityById($id);

        if (!$entity) {
            return $this->response([], Response::HTTP_NOT_FOUND);
        }

        $manager = $this->getManager();

        if ($request->file('file') === null) {
            return $this->error(['errors' => ['message' => 'Missing file']]);
        }

        $result = $manager->uploadFile(
            $entity,
            $request->file('file')
        );

        if (!$result->ok()) {
            return $this->error(['errors' => $result->getSimpleErrors()]);
        }

        return $this->success(['data' => $this->getManager()->getSerializer()->serialize($result->getResource())->toArray()], 201);
    }
}
