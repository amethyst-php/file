<?php

namespace Railken\LaraOre\File;

use Railken\Laravel\Manager\ModelRepository;

class FileRepository extends ModelRepository
{
    /**
     * Find a file that have the path.
     *
     * @param string $path
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function newQueryOneDiskPath($path)
    {
        return $this->getQuery()->where('path', 'like', '%'.$path.'%');
    }

    /**
     * Generate a new token
     *
     * @return string
     */
    public function generateToken()
    {
        do {
            $token = sha1(microtime());
        } while ($this->newQuery()->where(['token' => $token])->count() > 0);

        return $token;
    }

    /**
     * Find a file by token
     *
     * @param string $token
     *
     * @return File
     */
    public function findByToken(string $token)
    {
        return $this->findOneBy(['token' => $token]);
    }
}
