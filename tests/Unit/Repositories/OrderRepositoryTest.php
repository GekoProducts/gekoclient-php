<?php

namespace GekoProducts\HttpClient\Tests\Unit\Repositories;

use GekoProducts\HttpClient\Repositories\OrderRepository;
use GekoProducts\HttpClient\Resources\Order;
use GekoProducts\HttpClient\Tests\Support\TestingResourceServer;
use PHPUnit\Framework\TestCase;

class OrderRepositoryTest extends TestCase {

    private function server()
    {
        return TestingResourceServer::fake();
    }

    public function testCreateReturnsOrder()
    {
        $repo = new OrderRepository($this->server());

        $order = $repo->make();

        $this->assertInstanceOf(Order::class, $order);
    }
}
