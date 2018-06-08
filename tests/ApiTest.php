<?php

namespace Railken\LaraOre\File\Tests;

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
        return '/api/v1/admin/files';
    }

    public function signIn()
    {
        $response = $this->post('/api/v1/sign-in', [
            'username' => 'admin@admin.com',
            'password' => 'vercingetorige',
        ]);

        $access_token = json_decode($response->getContent())->data->access_token;
        
        $this->withHeaders(['Authorization' => 'Bearer '.$access_token]);

        return $response;
    }
    
    /**
     * Test common requests.
     *
     * @return void
     */
    public function testSuccessCommon()
    {
        $this->signIn();
        $this->commonTest($this->getBaseUrl(), $parameters = $this->getParameters());
    }

    public function commonTest($url, $parameters, $check = null)
    {
        if (!$check) {
            $check = $parameters;
        }
        
        # GET /
        $response = $this->get($url, []);
        $this->assertOrPrint($response, 200);

        # GET /
        $response = $this->get($url, ['query' => 'id eq 1']);
        $this->assertOrPrint($response, 200);
        
        # POST /
        $response = $this->post($url . "/upload", $parameters->toArray());
        $this->assertOrPrint($response, 201);
        $resource = json_decode($response)->resource->id;
        
        # GET /id
        $response = $this->get($url . "/". $resource->id);
        $this->assertOrPrint($response, 200);
       
        # DELETE /id
        $response = $this->delete($url . "/". $resource->id);
        $this->assertOrPrint($response, 204);
        $response = $this->get($url . "/". $resource->id);
        $this->assertOrPrint($response, 404);
    }
}
