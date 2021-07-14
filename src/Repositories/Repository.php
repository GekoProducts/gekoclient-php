<?php

namespace GekoProducts\HttpClient\Repositories;

use GekoProducts\HttpClient\Servers\ResourceServer;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

abstract class Repository {

    const REPO_ORDER = "order";

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

    public function getServer()
    {
        return $this->server;
    }
}
