<?php

namespace GekoProducts\HttpClient\Tests\Support;

use GekoProducts\HttpClient\Contracts\AuthorisationServer;
use GekoProducts\HttpClient\Servers\ProductionAuthorisationServer;
use GekoProducts\HttpClient\Servers\ResourceServer;
use GekoProducts\OAuth\Provider\GekoProducts;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class TestingResourceServer extends ResourceServer {

    protected $address = "http://geko-api.local";

    const ORG_ID = "AB0XX01";

    /**
     * TestingServer constructor.
     * @param string $orgId
     */
    public function __construct(string $orgId, Client $httpClient = null, AuthorisationServer $authServer = null)
    {
        parent::__construct($orgId, $this->address, $authServer);

        if (! is_null($httpClient)) {
            $this->httpClient = $httpClient;
        }
    }

    public static function fake(array $responseQueue = [])
    {
        ($authServer = new self(self::ORG_ID, self::mockHttpClient($responseQueue)))
            ->setAuthServer(static::mockAuthServer())
        ;

        return $authServer;
    }

    private static function mockAuthServer()
    {
        $provider = new GekoProducts([
            "clientId" => "1",
            "clientSecret" => "2j2smV28aGtANTVsISfbI4b5cN33b77r8yKr"
        ]);

        $response = \Mockery::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')
            ->andReturn('{"access_token":"mock_access_token", "scope":"test", "token_type":"bearer"}');
        $response->shouldReceive('getHeader')
            ->andReturn(['content-type' => 'application/json']);
        $response->shouldReceive('getStatusCode')
            ->andReturn(200);

        $client = \Mockery::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')->times(1)->andReturn($response);
        $provider->setHttpClient($client);


        $authServer = \Mockery::mock(ProductionAuthorisationServer::class, ["abc", "xyz"])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial()
        ;

        $authServer->shouldReceive("getAuthProvider")->andReturn($provider);

        return $authServer;
    }

    private static function mockHttpClient(array $responseQueue = [])
    {
        if (count($responseQueue) > 1) {
            $responseQueue[] = new Response(200);
        }

        $mock = new MockHandler($responseQueue);

        $handlerStack = HandlerStack::create($mock);

        return new Client(["handler" => $handlerStack]);
    }
}
