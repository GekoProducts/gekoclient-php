<?php

namespace GekoProducts\HttpClient\Tests\Feature\Order;

use GekoProducts\HttpClient\GekoClient;
use GekoProducts\HttpClient\Resources\Support\Contact;
use GekoProducts\HttpClient\Resources\Support\OrderLine;
use GekoProducts\HttpClient\Tests\Support\TestingServer;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class CreateOrderTest extends TestCase {

    public function testItCanSuccessfullyPlaceAnOrder()
    {
        $client = new GekoClient(
            TestingServer::fake([
                new Response(201, [], file_get_contents(__DIR__ . "/../../stubs/successful_order.json"))
            ])
        );

        ($contact = new Contact())
            ->setFirstName("John")
            ->setLastName("Smith")
            ->setAddressLine1("20 Longbow Street")
            ->setCity("Chesterfield")
            ->setCountry("United Kingdom")
            ->setPostcode("DE451AA")
        ;

        ($order = $client->order()->make())
            ->setShippingContact($contact)
            ->setBillingContact($contact)
            ->setOrderLines([
                (new OrderLine())->setSku("S-OR1423-D")
                    ->setDetail("Super awesome cool product")
                    ->setQuantity(2)
                    ->setPrice(4.99)
            ])
        ;


        $placedOrder = $client->order()->place($order);

        $this->assertNotNull($placedOrder->getAttribute("id"));
    }
}
