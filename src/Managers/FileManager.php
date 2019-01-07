<?php

namespace Railken\Amethyst\Managers;

use Illuminate\Support\Collection;
use Railken\Amethyst\Common\ConfigurableManager;
use Railken\Amethyst\Models\File;
use Railken\Lem\Contracts\EntityContract;
use Railken\Lem\Manager;
use Railken\Lem\Result;
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
     * @param File  $file
     * @param mixed $raw_file
     *
     * @return \Railken\Lem\Contracts\ResultContract
     */
    public function uploadFile(File $file, $raw_file)
    {
        $result = new Result();

        if (file_exists($raw_file)) {
            return $this->uploadFileFromFilesystem($file, $raw_file);
        }

        return $result;
    }

    /**
     * Upload file By content.
     *
     * @param File   $file
     * @param string $content
     *
     * @return \Railken\Lem\Contracts\ResultContract
     */
    public function uploadFileByContent(File $file, string $content)
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

        return $this->uploadFileFromFilesystem($file, $filename);
    }

    /**
     * Upload a file from filesystem.
     *
     * @param File   $file
     * @param string $path
     *
     * @return \Railken\Lem\Contracts\ResultContract
     */
    public function uploadFileFromFilesystem(File $file, string $path)
    {
        $result = $this->update($file, ['path' => $path]);
        $file->addMedia($file->path)->toMediaCollection('default');

        return $result;
    }

    public function assignToModel(File $file, EntityContract $entity, array $tagNames)
    {
        $result = new Result();

        $tagManager = new TagManager();
        $tagEntityManager = new TagEntityManager();

        $parentTag = $tagManager->findOrCreate([
            'name' => 'files',
        ])->getResource();

        foreach ($tagNames as $tagName) {
            $tag = $tagManager->findOrCreate([
                'name'      => $tagName,
                'parent_id' => $parentTag->id,
            ])->getResource();

            $tagEntityManager->findOrCreate([
                'tag_id'        => $tag->id,
                'taggable_type' => File::class,
                'taggable_id'   => $file->id,
            ]);
        }

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
}