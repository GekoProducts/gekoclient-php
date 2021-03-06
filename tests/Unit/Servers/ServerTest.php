<?php

namespace GekoProducts\HttpClient\Tests\Unit\Servers;

use GekoProducts\HttpClient\Servers\UriVerb;
use GekoProducts\HttpClient\Tests\Support\TestingResourceServer;
use PHPUnit\Framework\TestCase;

class ServerTest extends TestCase {

    private function server()
    {
        return new TestingResourceServer(TestingResourceServer::ORG_ID);
    }

    public function testGetUri()
    {
        $server = $this->server();

        $uri = $server->getUri(UriVerb::ORDERS_CREATE);

        $this->assertIsString($uri);
        $this->assertSame("/api/v1/orders", $uri);
    }
}
