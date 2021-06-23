<?php

namespace GekoProducts\HttpClient\Tests\Unit\Resources\Support;

use GekoProducts\HttpClient\Resources\Support\OrderLine;
use PHPUnit\Framework\TestCase;

class OrderLineTest extends TestCase {

    private function orderLine()
    {
        return new OrderLine();
    }

    public function testToArrayReturnsArray()
    {
        $line = $this->orderLine();

        $this->assertIsArray($line->toArray());
    }

    public function testToArrayHasRequiredAttributes()
    {
        $line = $this->orderLine();

        $attributes = $line->toArray();

        $this->assertArrayHasKey("sku", $attributes);
        $this->assertArrayHasKey("detail", $attributes);
        $this->assertArrayHasKey("price", $attributes);
        $this->assertArrayHasKey("quantity", $attributes);
    }

    public function testItCanSetSku()
    {
        $line = $this->orderLine();

        $line->setSku("A0001");

        $attributes = $line->toArray();

        $this->assertArrayHasKey("sku", $attributes);
        $this->assertSame("A0001", $attributes["sku"]);
    }

    public function testItCanSetDetail()
    {
        $line = $this->orderLine();

        $line->setDetail("Super awesome cool product");

        $attributes = $line->toArray();

        $this->assertArrayHasKey("detail", $attributes);
        $this->assertSame("Super awesome cool product", $attributes["detail"]);
    }

    public function testItCanSetQuantity()
    {
        $line = $this->orderLine();

        $line->setQuantity(3);

        $attributes = $line->toArray();

        $this->assertArrayHasKey("quantity", $attributes);
        $this->assertSame(3, $attributes["quantity"]);
    }

    public function testItCanSetPrice()
    {
        $line = $this->orderLine();

        $line->setPrice(10.98);

        $attributes = $line->toArray();

        $this->assertArrayHasKey("price", $attributes);
        $this->assertSame(10.98, $attributes["price"]);
    }

}
