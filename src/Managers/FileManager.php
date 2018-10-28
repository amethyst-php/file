<?php

namespace Railken\Amethyst\Managers;

use Railken\Amethyst\Common\ConfigurableManager;
use Railken\Amethyst\Models\File;
use Railken\Lem\Contracts\EntityContract;
use Railken\Lem\Manager;
use Ramsey\Uuid\Uuid;

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
        $dir = sys_get_temp_dir();

        $tmp = $dir.'/'.Uuid::uuid4()->toString();

        file_put_contents($tmp, $content);

        if (!$filename) {
            $filename = Uuid::uuid4()->toString().'.'.$this->guessExtension($tmp);
        }

        rename($tmp, $filename);

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

    /**
     * Guess extension from filename.
     *
     * @param string $filename
     *
     * @return string
     */
    public function guessExtension(string $filename)
    {
        $repository = new \Dflydev\ApacheMimeTypes\PhpRepository();

        $mimeType = mime_content_type($filename);

        $extensions = $repository->findExtensions($mimeType);

        if (count($extensions) === 0) {
            throw new \Exception(sprintf('Cannot find a valid extension for %s', $mimeType));
        }

        return $extensions[0];
    }
}
