<?php

namespace GekoProducts\HttpClient\Repositories;

use GekoProducts\HttpClient\Servers\ResourceServer;

abstract class Repository {

    const REPO_ORDER = "order";

    const REPO_PRODUCT = "product";

    /**
     * @var ResourceServer
     */
    private $server;

    /**
     * Repository constructor.
     * @param ResourceServer $server
     */
    public function __construct(ResourceServer $server)
    {
        $this->server = $server;
    }

    abstract public function make($attributes = []);

    public function makeCollection($orders = [])
    {
        $collection = array_map(function ($attributes) {
            return $this->make($attributes);
        }, $orders);

        return $collection;
    }

    public function getServer()
    {
        return $this->server;
    }
}
