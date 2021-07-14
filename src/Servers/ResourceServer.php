<?php

namespace GekoProducts\HttpClient\Servers;

use GekoProducts\HttpClient\Contracts\AuthorisationServer;
use GekoProducts\HttpClient\Exceptions\ServerResponseException;
use GekoProducts\HttpClient\Repositories\OrderRepository;
use GekoProducts\HttpClient\Repositories\Repository;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

abstract class ResourceServer {

    const HTTP_METHOD_POST = "POST";

    const HTTP_METHOD_GET = "GET";

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
     * @var AuthorisationServer $authServer
     */
    private $authServer;

    /**
     * Server constructor.
     * @param string $orgId
     * @param string $address
     */
    public function __construct(string $orgId)
    {
        $this->orgId = $orgId;

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
        return $this->request(self::HTTP_METHOD_GET, $uri, $headers);
    }

    public function post(string $uri, array $data, array $headers = [])
    {
        return $this->request(self::HTTP_METHOD_POST, $uri, $headers, $data);
    }

    public function getRepositories()
    {
        return [
            Repository::REPO_ORDER => new OrderRepository($this)
        ];
    }

    /**
     * @param AuthorisationServer $authServer
     */
    public function setAuthServer(AuthorisationServer $authServer = null): void
    {
        $this->authServer = $authServer;
    }

    protected function request(string $method, string $uri, array $headers, array $data = [])
    {
        switch ($method) {
            case self::HTTP_METHOD_POST:
                $data = json_encode($data);
                $request = new Request(self::HTTP_METHOD_POST, $uri, $headers, $data);
                break;
            default:
                $request = new Request(self::HTTP_METHOD_GET, $uri, $headers);
        }

        $request = $this->authoriseRequest($request);

        $response = $this->httpClient->send($request);

        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            return (string) $response->getBody();
        }

        throw new ServerResponseException($response);
    }

    protected function authoriseRequest(Request $request) : ?Request
    {
        if (is_null($this->authServer)) {
            return $request;
        }

        return $this->authServer->authoriseRequest($request);
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
