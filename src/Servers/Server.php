<?php

namespace GekoProducts\HttpClient\Servers;

use GekoProducts\HttpClient\Exceptions\ServerResponseException;
use GekoProducts\HttpClient\Repositories\OrderRepository;
use GekoProducts\HttpClient\Repositories\Repository;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

abstract class Server {

    /**
     * @var string $orgId
     */
    protected $orgId;

    /**
     * @var string $address
     */
    protected $address;

    /**
     * @var Client
     */
    protected $httpClient;

    /**
     * @var string $apiVersion
     */
    protected $apiVersion = "v1";

    /**
     * Server constructor.
     * @param string $orgId
     * @param string $address
     */
    public function __construct(string $orgId, string $address)
    {
        $this->orgId = $orgId;

        $this->address = $address;

        $this->setupHttpClient();
    }

    public function getUri(string $key)
    {
        $uris = $this->getUris();

        if (! array_key_exists($key, $uris)) {
            return "/";
        }

        return $uris[$key];
    }

    public function get(string $uri, array $headers = [])
    {
        $request = new Request("GET", $uri, $headers);

        $response = $this->httpClient->send($request);

        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            return (string) $response->getBody();
        }

        throw new ServerResponseException($response);
    }

    public function post(string $uri, array $data, array $headers = [])
    {
        $data = json_encode($data);
        $request = new Request("POST", $uri, $headers, $data);

        $response = $this->httpClient->send($request);

        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            return (string) $response->getBody();
        }

        throw new ServerResponseException($response);
    }

    public function getRepositories()
    {
        return [
            Repository::REPO_ORDER => new OrderRepository($this)
        ];
    }

    protected function setupHttpClient()
    {
        $this->httpClient = new Client([
            "base_uri" => $this->address,
            "headers" => [
                "X-Geko-Org-Id" => $this->orgId,
                "Content-Type" => "application/json",
                "Accept" => "application/json",
            ]
        ]);
    }

    protected function getUris()
    {
        return [
            UriVerb::ORDERS_CREATE => "/api/{$this->apiVersion}/orders",
            UriVerb::ORDERS_GET => "/api/{$this->apiVersion}/orders",
        ];
    }
}
