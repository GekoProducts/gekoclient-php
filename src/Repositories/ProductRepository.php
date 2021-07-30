<?php

namespace GekoProducts\HttpClient\Repositories;

use GekoProducts\HttpClient\Exceptions\ServerMalformedResponseException;
use GekoProducts\HttpClient\Resources\Product;
use GekoProducts\HttpClient\Servers\UriVerb;

class ProductRepository extends Repository
{
    public function make($attributes = [])
    {
        return new Product($attributes);
    }

    public function findBySku($sku)
    {
        $server = $this->getServer();

        $body = $server->get(
            $server->getUri(UriVerb::PRODUCTS_FIND_SKU) . "/$sku"
        );

        $data = json_decode($body, true);

        if (! $data) {
            throw new ServerMalformedResponseException($body);
        }

        return $this->make($data);
    }

    public function get()
    {
        $server = $this->getServer();

        $body = $server->get(
            $server->getUri(UriVerb::PRODUCTS_GET)
        );

        $data = json_decode($body, true);

        if (! $data) {
            throw new ServerMalformedResponseException($body);
        }

        return $this->makeCollection($data['data']);
    }
}
