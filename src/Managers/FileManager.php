<?php

namespace Railken\Amethyst\Managers;

use Railken\Amethyst\Common\ConfigurableManager;
use Railken\Amethyst\Models\File;
use Railken\Lem\Contracts\EntityContract;
use Railken\Lem\Manager;

class FileManager extends Manager
{
    use ConfigurableManager;

    /**
     * @var string
     */
    protected $config = 'amethyst.file.data.file';

    /**
     * Upload a file.
     *
     * @param mixed $raw_file
     *
     * @return \Railken\Lem\Contracts\ResultContract
     */
    public function uploadFile($raw_file)
    {
        if (file_exists($raw_file)) {
            return $this->uploadFileFromFilesystem($raw_file);
        }
    }

    /**
     * Upload file By content.
     *
     * @param string $content
     * @param string $filename
     *
     * @return \Railken\Lem\Contracts\ResultContract
     */
    public function uploadFileByContent(string $content, string $filename = null)
    {
        $filename = sys_get_temp_dir().'/'.$filename;
        file_put_contents($filename, $content);

        return $this->uploadFileFromFilesystem($filename);
    }

    /**
     * Upload a file from filesystem.
     *
     * @param string $filename
     *
     * @return \Railken\Lem\Contracts\ResultContract
     */
    public function uploadFileFromFilesystem(string $filename)
    {
        $result = $this->create([]);
        $resource = $result->getResource();
        $resource->addMedia($filename)->preservingOriginal()->toMediaCollection('default');

        return $result;
    }

    public function assignToModel(File $file, EntityContract $entity, array $extra)
    {
        $file->model()->associate($entity);

        return $this->update($file, $extra);
    }
}
