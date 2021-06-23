<?php

namespace GekoProducts\HttpClient\Repositories;

use GekoProducts\HttpClient\Resources\Order;
use GekoProducts\HttpClient\Servers\UriVerb;

class OrderRepository extends Repository {

    public function make($attributes = [])
    {
        return new Order($attributes);
    }

    public function place(Order $order)
    {
        $server = $this->getServer();

        try {
            $orderBody = $server->post(
                $server->getUri(UriVerb::ORDER_CREATE),
                $order->getAttributes()
            );

            $orderData = json_decode($orderBody, true);

            return $this->make($orderData['data']);

        } catch (\Exception $e) {

        }
    }
}
