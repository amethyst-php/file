<?php

namespace Amethyst\Tests\Http;

use Amethyst\Core\Support\Testing\TestableBaseTrait;
use Amethyst\Fakers\FileFaker;
use Amethyst\Tests\Base;
use Illuminate\Http\UploadedFile;

class FileTest extends Base
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
    protected $group = 'data.file';

    /**
     * Base Route.
     *
     * @var string
     */
    protected $route = 'data.file';

    /**
     * Test upload.
     */
    public function testHttpUpload()
    {
        $response = $this->callAndTest('POST', route('data.create', ['name' => 'file']), ['name' => 'yolo'], 201);
        $body = json_decode($response->getContent());

        $response = $this->callAndTest('POST', route('app.file.upload', ['id' => $body->data->id]), [
            'file' => UploadedFile::fake()->image('text.txt'),
        ], 200);

        $body = json_decode($response->getContent());

        $response = $this->callAndTest('GET', route('app.file.stream', ['id' => $body->data->id, 'name' => 'yolo']), [], 200);
    }

}
