<?php

namespace GekoProducts\HttpClient;

use GekoProducts\HttpClient\Contracts\AuthorisationServer;
use GekoProducts\HttpClient\Repositories\OrderRepository;
use GekoProducts\HttpClient\Repositories\Repository;
use GekoProducts\HttpClient\Servers\ProductionResourceServer;
use GekoProducts\HttpClient\Servers\ResourceServer;

class GekoClient {

    /**
     * @var ResourceServer $server
     */
    private $server;

    /**
     * GekoClient constructor.
     * @param ResourceServer $server
     */
    public function __construct(ResourceServer $server)
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

    public static function asOrg($org, AuthorisationServer $authServer = null)
    {
        if ($org instanceof ResourceServer) {
            $server = $org;
        } else {
            $server = new ProductionResourceServer($org);
        }

        $server->setAuthServer($authServer);

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
