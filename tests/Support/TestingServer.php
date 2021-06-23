<?php

namespace GekoProducts\HttpClient\Tests\Support;

use GekoProducts\HttpClient\Servers\Server;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class TestingServer extends Server {

    protected $address = "http://geko-api.local";

    const ORG_ID = "AB0XX01";

    /**
     * TestingServer constructor.
     * @param string $orgId
     */
    public function __construct(string $orgId, Client $httpClient = null)
    {
        parent::__construct($orgId, $this->address);

        if (! is_null($httpClient)) {
            $this->httpClient = $httpClient;
        }
    }

    public static function fake(array $responseQueue = [])
    {
        return new self(self::ORG_ID, self::mockHttpClient($responseQueue));
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
