<?php

namespace Amethyst\Tests\Http\Admin;

use Amethyst\Core\Support\Testing\TestableBaseTrait;
use Amethyst\Fakers\FileFaker;
use Amethyst\Tests\BaseTest;
use Illuminate\Http\UploadedFile;

class FileTest extends BaseTest
{
    use TestableBaseTrait;

    /**
     * Faker class.
     *
     * @var string
     */
    protected $faker = FileFaker::class;

    /**
     * Router group resource.
     *
     * @var string
     */
    protected $group = 'admin';

    /**
     * Base Route.
     *
     * @var string
     */
    protected $route = 'admin.file';

    /**
     * Test upload.
     */
    public function testHttpUpload()
    {
        $response = $this->callAndTest('POST', route('admin.file.create'), [], 201);
        $body = json_decode($response->getContent());

        $response = $this->callAndTest('POST', route('admin.file.upload', ['id' => $body->data->id]), [
            'file' => UploadedFile::fake()->image('text.txt'),
        ], 201);

        $body = json_decode($response->getContent());

        $response = $this->callAndTest('GET', route('admin.file.download', ['id' => $body->data->id]), 201);

        print_r($response->getContent());
    }
}
