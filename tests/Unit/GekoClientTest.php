<?php

namespace GekoProducts\HttpClient\Tests\Unit;

use GekoProducts\HttpClient\GekoClient;
use GekoProducts\HttpClient\Repositories\OrderRepository;
use GekoProducts\HttpClient\Tests\Support\TestingResourceServer;
use PHPUnit\Framework\TestCase;

class GekoClientTest extends TestCase {

    public function testOrderReturnsOrderRepository()
    {
        $client = new GekoClient(TestingResourceServer::fake());

        $orderRepo = $client->order();

        $this->assertInstanceOf(OrderRepository::class, $orderRepo);
    }

    public function testInitAsOrg()
    {
        $client = GekoClient::asOrg(TestingResourceServer::ORG_ID);

        $this->assertInstanceOf(GekoClient::class, $client);
    }
}
