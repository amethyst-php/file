<?php

namespace Railken\Amethyst\Managers;

use Illuminate\Support\Collection;
use Railken\Amethyst\Common\ConfigurableManager;
use Railken\Amethyst\Models\File;
use Railken\Lem\Contracts\EntityContract;
use Railken\Lem\Manager;
use Railken\Lem\Result;
use Ramsey\Uuid\Uuid;
use Closure;

/**
 * @method \Railken\Amethyst\Repositories\FileRepository getRepository()
 */
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
     * @param File  $file
     * @param mixed $raw_file
     * @param Closure $media
     *
     * @return \Railken\Lem\Contracts\ResultContract
     */
    public function uploadFile(File $file, $raw_file, Closure $media = null)
    {
        $result = new Result();

        if (file_exists($raw_file)) {
            return $this->uploadFileFromFilesystem($file, $raw_file, $media);
        }

        return $result;
    }

    /**
     * Upload file By content.
     *
     * @param File   $file
     * @param string $content
     * @param Closure $media
     *
     * @return \Railken\Lem\Contracts\ResultContract
     */
    public function uploadFileByContent(File $file, string $content, Closure $media = null)
    {
        $dir = sys_get_temp_dir();

        $tmp = $dir.'/'.Uuid::uuid4()->toString();

        file_put_contents($tmp, $content);

        $filename = $file->name;

        if (!$filename) {
            $filename = Uuid::uuid4()->toString().'.'.$this->guessExtension($tmp);
        }

        $filename = $dir.'/'.$filename;

        rename($tmp, $filename);

        return $this->uploadFileFromFilesystem($file, $filename, $media);
    }

    /**
     * Upload a file from filesystem.
     *
     * @param File   $file
     * @param string $path
     * @param Closure $media
     *
     * @return \Railken\Lem\Contracts\ResultContract
     */
    public function uploadFileFromFilesystem(File $file, string $path, Closure $media = null)
    {
        $dir = sys_get_temp_dir();

        if (!$file->public) {
            $filename = $dir.'/'.Uuid::uuid4()->toString().'.'.$this->guessExtension($path);
        } else {
            $filename = $dir.'/'.$file->name;
        }

        rename($path, $filename);

        $file->path = $filename;
        $file->save();

        $mediaBuilder = $file->addMedia($file->path);

        if ($file->public) {
            $mediaBuilder->addCustomHeaders([
                'visibility' => 'public',
            ]);
        }

        if ($media && is_callable($media)) {
            $media($mediaBuilder);
        }


        $mediaBuilder->toMediaCollection('default');

        $result = new Result();
        $result->setResources(Collection::make([$file]));

        return $result;
    }

    public function assignToModel(File $file, EntityContract $entity)
    {
        $result = new Result();

        $file->model()->associate($entity);
        $file->save();

        $result->setResources(Collection::make($file));

        return $result;
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
        $mimeType = mime_content_type($filename);

        return $this->findExtension($mimeType);
    }

    /**
     * @var string
     */
    public function findExtension(string $mimeType)
    {
        $repository = new \Dflydev\ApacheMimeTypes\PhpRepository();

        $extensions = $repository->findExtensions($mimeType);

        if (count($extensions) === 0) {
            throw new \Exception(sprintf('Cannot find a valid extension for %s', $mimeType));
        }

        return $extensions[0];
    }

    /**
     * Generate random name by mime type.
     *
     * @param string $mimeType
     *
     * @return string
     */
    public function randomNameByMimeType(string $mimeType)
    {
        return Uuid::uuid4()->toString().'.'.$this->findExtension($mimeType);
    }

    /**
     * Describe extra actions.
     *
     * @return array
     */
    public function getDescriptor()
    {
        return [
            'file' => [
                'type'   => 'file',
                'action' => 'upload',
            ],
        ];
    }
}
