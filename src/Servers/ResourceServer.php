<?php

namespace GekoProducts\HttpClient\Servers;

use GekoProducts\HttpClient\Contracts\AuthorisationServer;
use GekoProducts\HttpClient\Exceptions\InvalidRequestException;
use GekoProducts\HttpClient\Exceptions\ResourceNotFoundException;
use GekoProducts\HttpClient\Exceptions\ResourceServerException;
use GekoProducts\HttpClient\Exceptions\ServerResponseException;
use GekoProducts\HttpClient\Repositories\OrderRepository;
use GekoProducts\HttpClient\Repositories\ProductRepository;
use GekoProducts\HttpClient\Repositories\Repository;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ResourceServer
 * @package GekoProducts\HttpClient\Servers
 */
abstract class ResourceServer
{
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

    /**
     * @param string $key
     * @return string
     */
    public function getUri(string $key)
    {
        $uris = $this->getUris();

        if (!array_key_exists($key, $uris)) {
            return "/";
        }

        return $uris[$key];
    }

    /**
     * @param string $uri
     * @param array $headers
     * @return string
     * @throws ResourceNotFoundException
     * @throws ResourceServerException
     * @throws ServerResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(string $uri, array $headers = [])
    {
        return $this->request(self::HTTP_METHOD_GET, $uri, $headers);
    }

    /**
     * @param string $uri
     * @param array $data
     * @param array $headers
     * @return string
     * @throws ResourceNotFoundException
     * @throws ResourceServerException
     * @throws ServerResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(string $uri, array $data, array $headers = [])
    {
        return $this->request(self::HTTP_METHOD_POST, $uri, $headers, $data);
    }

    public function getRepositories()
    {
        return [
            Repository::REPO_ORDER => new OrderRepository($this),
            Repository::REPO_PRODUCT => new ProductRepository($this)
        ];
    }

    /**
     * @param AuthorisationServer $authServer
     */
    public function setAuthServer(AuthorisationServer $authServer = null): void
    {
        $this->authServer = $authServer;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $headers
     * @param array $data
     * @return string
     * @throws ResourceNotFoundException
     * @throws ResourceServerException
     * @throws ServerResponseException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
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

        try {
            $response = $this->httpClient->send($request);

            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                return (string)$response->getBody();
            }

            throw new ServerResponseException($response);
        } catch (ClientException $clientException) {
            $response = $clientException->getResponse();

            $this->handleResourceServerResponse($response);
        }
    }

    /**
     * @param Request $request
     * @return Request
     */
    protected function authoriseRequest(Request $request)
    {
        if (is_null($this->authServer)) {
            return $request;
        }

        return $this->authServer->authoriseRequest($request);
    }

    protected function setupHttpClient()
    {
        $this->httpClient = new Client(
            [
                "base_uri" => $this->address,
                "headers" => [
                    "X-Geko-Org-Id" => $this->orgId,
                    "Content-Type" => "application/json",
                    "Accept" => "application/json",
                ]
            ]
        );
    }

    /**
     * @return string[]
     */
    protected function getUris()
    {
        return [
            UriVerb::ORDERS_CREATE => "/api/{$this->apiVersion}/orders",
            UriVerb::ORDERS_GET => "/api/{$this->apiVersion}/orders",

            UriVerb::PRODUCTS_GET => "/api/{$this->apiVersion}/products",
            UriVerb::PRODUCTS_FIND_SKU => "/api/{$this->apiVersion}/products",
        ];
    }

    /**
     * @param ResponseInterface $response
     * @throws InvalidRequestException
     * @throws ResourceNotFoundException
     * @throws ResourceServerException
     */
    private function handleResourceServerResponse(ResponseInterface $response)
    {
        $statusCode = $response->getStatusCode();
        $responseBody = $response->getBody();

        switch ($statusCode) {
            case 404:
                throw new ResourceNotFoundException("The requested resource could not be found.");
            case 422:
                throw new InvalidRequestException($response);
            default:
                throw new ResourceServerException("The resource server failed to fulfill the request. [$statusCode] [$responseBody]");
        }
    }
}
