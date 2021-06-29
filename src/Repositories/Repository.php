<?php

namespace GekoProducts\HttpClient\Repositories;

use GekoProducts\HttpClient\Servers\Server;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

abstract class Repository {

    const REPO_ORDER = "order";

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

    public function getServer()
    {
        return $this->server;
    }
}
