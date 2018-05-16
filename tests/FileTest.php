<?php

namespace Railken\LaraOre\File\Tests;

use Railken\Bag;
use Railken\LaraOre\File\Tests\Models\Foo;

/**
 * Testing disk
 * Attributes to fill are: name, driver, enabled, config.
 */
class FileTest extends BaseTest
{
    use Traits\CommonTrait;
    
    /**
     * Retrieve basic url.
     *
     * @return \Railken\Laravel\Manager\Contracts\ManagerContract
     */
    public function getManager()
    {
    }


    public function testStorage()
    {
        $foo = new Foo();

        $foo->addMedia(__DIR__ . "/files/1px.png")->toMediaCollection('images');
    }

}
