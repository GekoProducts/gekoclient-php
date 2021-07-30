<?php

namespace GekoProducts\HttpClient\Tests\Unit\Servers;

use GekoProducts\HttpClient\Servers\ProductionAuthorisationServer;
use GekoProducts\OAuth\Provider\GekoProducts;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class ProductionAuthorisationServerTest extends TestCase {

    protected $provider;

    protected function setUp(): void
    {
        $this->provider = new GekoProducts([
            "clientId" => "abc",
            "clientSecret" => "xyz"
        ]);
    }

    public function testItAddsAuthHeaders()
    {
        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')
            ->andReturn('{"access_token":"mock_access_token", "scope":"test", "token_type":"bearer"}');
        $response->shouldReceive('getHeader')
            ->andReturn(['content-type' => 'application/json']);
        $response->shouldReceive('getStatusCode')
            ->andReturn(200);

        $client = \Mockery::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')->times(1)->andReturn($response);
        $this->provider->setHttpClient($client);


        $authServer = \Mockery::mock(ProductionAuthorisationServer::class, ["abc", "xyz"])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial()
        ;

        $authServer->shouldReceive("getAuthProvider")->andReturn($this->provider);

        $request = new Request("POST", "/hello/world", ["x-abc" => "xyz"]);

        $request = $authServer->authoriseRequest($request);

        $headers = $request->getHeaders();
        $this->assertArrayHasKey("Authorization", $headers);
        $this->assertSame("Bearer mock_access_token", $headers["Authorization"][0]);
    }
}
