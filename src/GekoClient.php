<?php

namespace GekoProducts\HttpClient;

use GekoProducts\HttpClient\Repositories\OrderRepository;
use GekoProducts\HttpClient\Servers\ProductionServer;
use GekoProducts\HttpClient\Servers\Server;

class GekoClient {

    /**
     * @var Server $server
     */
    private $server;

    /**
     * GekoClient constructor.
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    public function order()
    {
        return new OrderRepository($this->server);
    }

    public static function asOrg(string $orgId, string $server = null)
    {
        if (is_null($server)) {
            $server = new ProductionServer($orgId);
        }

        $reflectionClass = new \ReflectionClass($server);
        $server = $reflectionClass->newInstance($orgId);

        if (! $server instanceof Server) {
            throw new \Exception("The server must be an instance of \GekoProducts\HttpClient\Servers\Server");
        }

        return new self($server);
    }
}
