<?php

namespace Amethyst\Http\Controllers;

use Amethyst\Core\Http\Controllers\RestManagerController;
use Amethyst\Managers\FileManager;
use Illuminate\Http\Request;
use Railken\LaraEye\Exceptions\FilterSyntaxException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @method \Amethyst\Managers\FileManager getManager()
 */
class FileController extends RestManagerController
{
    /**
     * The class of the manager.
     *
     * @var string
     */
    public $class = FileManager::class;

    /**
     * The attributes that are fillable.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function upload(Request $request)
    {
        $query = $this->getQuery();

        try {
            $this->filterQuery($query, $request);
        } catch (FilterSyntaxException $e) {
            return $this->error(['code' => 'QUERY_SYNTAX_ERROR', 'message' => $e->getMessage()]);
        }

        $entity = $query->first();

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

        return $this->response($this->serialize($result->getResource(), $request), Response::HTTP_OK);
    }

    /**
     * The attributes that are fillable.
     *
     * @param mixed   $id
     * @param mixed   $name
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function stream($id, $name, Request $request)
    {
        $entity = $this->getEntityById($id);

        if (!$entity) {
            return abort(404);
        }

        $manager = $this->getManager();

        return response()->file($entity->downloadable(), [
          'Content-Disposition' => 'inline; filename="'.$entity->name.'"',
        ]);
    }
}
