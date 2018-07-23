<?php

namespace Railken\LaraOre\File;

use Illuminate\Support\Facades\Config;
use Railken\Laravel\Manager\Contracts\AgentContract;
use Railken\Laravel\Manager\Contracts\EntityContract;
use Railken\Laravel\Manager\ModelManager;
use Railken\Laravel\Manager\Tokens;

class FileManager extends ModelManager
{
    /**
     * Class name entity.
     *
     * @var string
     */
    public $entity = File::class;

    /**
     * List of all attributes.
     *
     * @var array
     */
    protected $attributes = [
        Attributes\Id\IdAttribute::class,
        Attributes\UpdatedAt\UpdatedAtAttribute::class,
        Attributes\DeletedAt\DeletedAtAttribute::class,
        Attributes\Tags\TagsAttribute::class,
        Attributes\Token\TokenAttribute::class,
    ];

    /**
     * List of all exceptions.
     *
     * @var array
     */
    protected $exceptions = [
        Tokens::NOT_AUTHORIZED => Exceptions\FileNotAuthorizedException::class,
    ];

    /**
     * Construct.
     *
     * @param AgentContract $agent
     */
    public function __construct(AgentContract $agent = null)
    {
        $this->entity = Config::get('ore.file.entity');
        $this->attributes = array_merge($this->attributes, array_values(Config::get('ore.file.attributes')));

        $classRepository = Config::get('ore.file.repository');
        $this->setRepository(new $classRepository($this));

        $classSerializer = Config::get('ore.file.serializer');
        $this->setSerializer(new $classSerializer($this));

        $classAuthorizer = Config::get('ore.file.authorizer');
        $this->setAuthorizer(new $classAuthorizer($this));

        $classValidator = Config::get('ore.file.validator');
        $this->setValidator(new $classValidator($this));

        parent::__construct($agent);
    }

    /**
     * Upload a file.
     *
     * @param mixed $raw_file
     *
     * @return \Railken\Laravel\Manager\Contracts\ResultContract
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
     * @return \Railken\Laravel\Manager\Contracts\ResultContract
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
     * @return \Railken\Laravel\Manager\Contracts\ResultContract
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
