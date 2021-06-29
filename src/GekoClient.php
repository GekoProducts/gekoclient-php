<?php

namespace GekoProducts\HttpClient;

use GekoProducts\HttpClient\Repositories\OrderRepository;
use GekoProducts\HttpClient\Repositories\Repository;
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

    /**
     * @return OrderRepository
     */
    public function order()
    {
        return $this->repository(Repository::REPO_ORDER);
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

    /**
     * @param $key
     * @return Repository|null
     */
    private function repository($key)
    {
        $repos = $this->server->getRepositories();

        if (! array_key_exists($key, $repos)) {
            return null;
        }

        return $repos[$key];
    }
}
