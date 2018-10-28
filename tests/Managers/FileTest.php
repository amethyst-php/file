<?php

namespace Railken\Amethyst\Tests\Managers;

use Railken\Amethyst\Fakers\FileFaker;
use Railken\Amethyst\Managers\FileManager;
use Railken\Amethyst\Tests\BaseTest;
use Railken\Amethyst\Tests\Laravel\App\Foo;
use Railken\Lem\Support\Testing\TestableBaseTrait;

class FileTest extends BaseTest
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
        $result = $manager->uploadFileByContent('test');
        $this->assertEquals(true, $result->ok());
    }

    public function testFile()
    {
        $manager = new FileManager();

        // Create a temporary file.
        $result = $manager->uploadFileByContent('test', 'test.txt');
        $result = $manager->uploadFile(__DIR__.'/../Laravel/storage/tardis.png');

        $this->assertEquals(true, $result->ok());

        $resource = $result->getResource();

        $this->assertEquals(true, filter_var($resource->getFullUrl(), FILTER_VALIDATE_URL) ? true : false);

        // Retrieve the temporary file by token
        $this->assertEquals($manager->getRepository()->findByToken($resource->token)->id, $resource->id);

        // Assign the temporary file to a model
        $manager->assignToModel($resource, $foo = Foo::create(), ['tags' => ['test']]);

        $files = $foo->getFiles(['test']);

        $this->assertEquals($resource->getFullUrl(), $files[0]->getFullUrl());
    }
}
