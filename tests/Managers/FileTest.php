<?php

namespace Amethyst\Tests\Managers;

use Amethyst\Fakers\FileFaker;
use Amethyst\Managers\FileManager;
use Amethyst\Tests\Base;
use Amethyst\Tests\Laravel\App\Foo;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class FileTest extends Base
{
    use TestableBaseTrait;

    /**
     * Manager class.
     *
     * @var string
     */
    protected $manager = FileManager::class;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = FileFaker::class;

    public function testUploadFileByContent()
    {
        $manager = new FileManager();

        $resource = $manager->create(FileFaker::make()->parameters())->getResource();

        $result = $manager->uploadFileByContent($resource, 'test');
        $this->assertEquals(true, $result->ok());
    }

    public function testManagerFile()
    {
        $manager = new FileManager();

        $path = __DIR__.'/../Laravel/storage/tardis.txt';
        file_put_contents($path, 'Allons-y!');

        $resource = $manager->create(FileFaker::make()->parameters())->getResource();


        // Create a temporary file.
        $result = $manager->uploadFileByContent($resource, 'test');
        $result = $manager->uploadFile($resource, $path);

        $resource = $result->getResource();


        $resource->refresh();
        $this->assertEquals(true, $result->ok());

        $this->assertEquals(true, filter_var($resource->getFullUrl(), FILTER_VALIDATE_URL) ? true : false);

        // Retrieve the temporary file by token
        $this->assertEquals($manager->getRepository()->findByToken($resource->token)->id, $resource->id);

    }
}
