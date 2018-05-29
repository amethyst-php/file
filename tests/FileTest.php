<?php

namespace Railken\LaraOre\File\Tests;

use Railken\Bag;
use Railken\LaraOre\File\Tests\Laravel\App\Foo\Foo;
use Railken\LaraOre\File\Tests\Laravel\App\Foo\FooManager;
use Railken\LaraOre\File\FileManager;

/**
 * Testing disk
 * Attributes to fill are: name, driver, enabled, config.
 */
class FileTest extends BaseTest
{
    use Traits\CommonTrait;
    

    public function testFile()
    {
        $manager = new FileManager();
        $fm = new FooManager();

        // Create a temporary file.
        $result = $manager->uploadFile(__DIR__ . "/Laravel/storage/tardis.png");

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
