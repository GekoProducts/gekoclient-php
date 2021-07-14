<?php

namespace GekoProducts\HttpClient\Servers;

use GekoProducts\HttpClient\Contracts\AuthorisationServer;
use GekoProducts\OAuth\Provider\GekoProducts as AuthProvider;
use GuzzleHttp\Psr7\Request;
use League\OAuth2\Client\Token\AccessTokenInterface;

class ProductionAuthorisationServer implements AuthorisationServer {

    /**
     * @var AuthProvider
     */
    private $authProvider;

    /**
     * @var string $clientId
     */
    private $clientId;

    /**
     * @var string $clientSecret
     */
    private $clientSecret;

    /**
     * ProductionAuthorisationServer constructor.
     * @param string $clientId
     * @param string $clientSecret
     */
    public function __construct(string $clientId, string $clientSecret)
    {
        $this->clientId = $clientId;

        $this->clientSecret = $clientSecret;
    }

    public function authoriseRequest(Request $request) : Request
    {
        $accessToken = $this->getAuthToken();

        $updatedRequest = $request->withHeader("Authorization", "Bearer " . $accessToken->getToken());

        return $updatedRequest;
    }

    protected function getAuthProvider()
    {
        if (! is_null($this->authProvider)) {
            return $this->authProvider;
        }

        return $this->authProvider = new AuthProvider([
            "client_id" => $this->clientId,
            "client_secret" => $this->clientSecret
        ]);
    }

    /**
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    private function getAuthToken() : AccessTokenInterface
    {
        return $this->getAuthProvider()->getAccessToken("client_credentials");
    }
}
