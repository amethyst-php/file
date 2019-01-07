<?php

namespace Railken\Amethyst\Tests\Http\Admin;

use Illuminate\Http\UploadedFile;
use Railken\Amethyst\Api\Support\Testing\TestableBaseTrait;
use Railken\Amethyst\Fakers\FileFaker;
use Railken\Amethyst\Tests\BaseTest;

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
        $response = $this->callAndTest('POST', route('admin.file.create'), [
            'name'        => 'test.txt',
        ], 201);
        $body = json_decode($response->getContent());

        $response = $this->callAndTest('POST', route('admin.file.upload', ['id' => $body->data->id]), [
            'file' => UploadedFile::fake()->image('text.txt'),
        ], 201);
        $body = json_decode($response->getContent());
    }
}
