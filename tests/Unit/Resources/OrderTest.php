<?php

namespace GekoProducts\HttpClient\Tests\Unit\Resources;

use GekoProducts\HttpClient\Resources\Order;
use GekoProducts\HttpClient\Resources\Support\Contact;
use GekoProducts\HttpClient\Resources\Support\OrderLine;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase {

    private function emptyOrder()
    {
        return new Order();
    }

    public function testItCanSetPoNumber()
    {
        $order = $this->emptyOrder();

        $this->assertArrayNotHasKey("po_number", $order->getAttributes());

        $order->setPoNumber("#0001");

        $attributes = $order->getAttributes();

        $this->assertArrayHasKey("po_number", $attributes);
    }

    public function testItCanSetPoDate()
    {
        $order = $this->emptyOrder();

        $this->assertArrayNotHasKey("po_date", $order->getAttributes());

        $order->setPoDate("2021-06-23 15:45");

        $attributes = $order->getAttributes();

        $this->assertArrayHasKey("po_date", $attributes);
    }

    public function testItCanSetComments()
    {
        $order = $this->emptyOrder();

        $this->assertArrayNotHasKey("comments", $order->getAttributes());

        $order->setComments("2021-06-23 15:45");

        $attributes = $order->getAttributes();

        $this->assertArrayHasKey("comments", $attributes);
    }

    public function testItCanLines()
    {
        $order = $this->emptyOrder();

        $this->assertArrayNotHasKey("lines", $order->getAttributes());

        $order->setOrderLines([
            new OrderLine()
        ]);

        $attributes = $order->getAttributes();

        $this->assertArrayHasKey("lines", $attributes);
    }

    public function testItCanSetBillingContact()
    {
        $order = $this->emptyOrder();

        $this->assertArrayNotHasKey("contacts", $order->getAttributes());

        $order->setBillingContact(
            (new Contact())
        );

        $attributes = $order->getAttributes();

        $this->assertArrayHasKey("contacts", $attributes);
        $this->assertArrayHasKey("billing", $attributes["contacts"]);
    }

    public function testItCanSetShippingContact()
    {
        $order = $this->emptyOrder();

        $this->assertArrayNotHasKey("contacts", $order->getAttributes());

        $order->setShippingContact(
            (new Contact())
        );

        $attributes = $order->getAttributes();

        $this->assertArrayHasKey("contacts", $attributes);
        $this->assertArrayHasKey("shipping", $attributes["contacts"]);
    }
}
