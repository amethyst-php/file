<?php

namespace Railken\LaraOre\File\Tests;

use Railken\Bag;
use Railken\LaraOre\File\Tests\Laravel\App\Foo;

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
        $foo = Foo::create();

        $foo->addMedia(__DIR__ . "/Laravel/storage/tardis.png")->preservingOriginal()->toMediaCollection('images');

        $foo->getFirstMediaUrl('images', 'thumb');

    }

}
