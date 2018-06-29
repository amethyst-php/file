<?php

namespace Railken\LaraOre\File;

use Railken\Bag;
use Faker\Factory;

class FileFaker
{
    /**
     * @return array
     */
    public static function make()
    {
        $faker = Factory::create();
        
        $bag = new Bag();
        $bag->set('name', 'test.txt');
        $bag->set('file', str_random(40));

        return $bag;
    }
}
