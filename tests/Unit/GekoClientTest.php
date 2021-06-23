<?php

namespace GekoProducts\HttpClient\Tests\Unit;

use GekoProducts\HttpClient\GekoClient;
use GekoProducts\HttpClient\Repositories\OrderRepository;
use GekoProducts\HttpClient\Tests\Support\TestingServer;
use PHPUnit\Framework\TestCase;

class GekoClientTest extends TestCase {

    public function testOrderReturnsOrderRepository()
    {
        $client = new GekoClient(TestingServer::fake());

        $orderRepo = $client->order();

        $this->assertInstanceOf(OrderRepository::class, $orderRepo);
    }

    public function testInitAsOrg()
    {
        $client = GekoClient::asOrg(TestingServer::ORG_ID, TestingServer::class);

        $this->assertInstanceOf(GekoClient::class, $client);
    }
}
