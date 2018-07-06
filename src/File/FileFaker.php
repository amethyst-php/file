<?php

namespace Railken\LaraOre\File;

use Railken\Bag;
use Faker\Factory;
use Railken\Laravel\Manager\BaseFaker;

class FileFaker extends BaseFaker
{
    /**
     * @var string
     */
    protected $manager = FileManager::class;

    /**
     * @return \Railken\Bag
     */
    public function parameters()
    {
        $faker = Factory::create();
        
        $bag = new Bag();
        $bag->set('name', 'test.txt');
        $bag->set('file', str_random(40));

        return $bag;
    }
}
