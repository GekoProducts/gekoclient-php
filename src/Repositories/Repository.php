<?php

namespace GekoProducts\HttpClient\Repositories;

use GekoProducts\HttpClient\Servers\Server;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

abstract class Repository {

    /**
     * @var Server
     */
    private $server;

    /**
     * Repository constructor.
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    protected function getServer()
    {
        return $this->server;
    }
}
