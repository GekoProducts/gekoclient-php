<?php

namespace GekoProducts\HttpClient\Repositories;

use GekoProducts\HttpClient\Exceptions\ServerMalformedResponseException;
use GekoProducts\HttpClient\Resources\Order;
use GekoProducts\HttpClient\Servers\UriVerb;

class OrderRepository extends Repository {

    public function makeCollection($orders = [])
    {
        $collection = array_map(function ($attributes) {
            return $this->make($attributes);
        }, $orders);

        return $collection;
    }

    public function make($attributes = [])
    {
        return new Order($attributes);
    }

    public function get()
    {
        $server = $this->getServer();

        $ordersBody = $server->get(
            $server->getUri(UriVerb::ORDERS_GET),
        );

        $ordersData = json_decode($ordersBody, true);

        if (! $ordersData) {
            throw new ServerMalformedResponseException($ordersBody);
        }

        return $this->makeCollection($ordersData['data']);
    }

    public function place(Order $order)
    {
        $server = $this->getServer();

        $orderBody = $server->post(
            $server->getUri(UriVerb::ORDERS_CREATE),
            $order->getAttributes()
        );

        $orderData = json_decode($orderBody, true);

        if (! $orderData) {
            throw new ServerMalformedResponseException($orderBody);
        }

        return $this->make($orderData['data']);
    }
}
