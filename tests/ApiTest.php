<?php

namespace Railken\LaraOre\File\Tests;

use Illuminate\Support\Facades\Config;
use Railken\LaraOre\Support\Testing\ApiTestableTrait;

class ApiTest extends BaseTest
{
    use ApiTestableTrait;

    /**
     * Retrieve basic url.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return Config::get('ore.api.router.prefix').Config::get('ore.file.router.prefix');
    }

    /**
     * Test common requests.
     *
     * @return void
     */
    public function testSuccessCommon()
    {
        $this->commonTest($this->getBaseUrl(), $parameters = $this->getParameters());
    }

    public function commonTest($url, $parameters, $check = null)
    {
        if (!$check) {
            $check = $parameters;
        }

        // GET /
        $response = $this->get($url, []);
        $this->assertOrPrint($response, 200);

        // GET /
        $response = $this->get($url, ['query' => 'id eq 1']);
        $this->assertOrPrint($response, 200);

        // POST /
        $response = $this->post($url.'/upload', $parameters->toArray());
        $this->assertOrPrint($response, 201);
        $resource = json_decode($response->getContent())->resource;

        // GET /id
        $response = $this->get($url.'/'.$resource->id);
        $this->assertOrPrint($response, 200);

        // DELETE /id
        $response = $this->delete($url.'/'.$resource->id);
        $this->assertOrPrint($response, 204);
        $response = $this->get($url.'/'.$resource->id);
        $this->assertOrPrint($response, 404);
    }
}
