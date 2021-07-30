<?php

namespace GekoProducts\HttpClient\Servers\Traits;

use GekoProducts\OAuth\Provider\GekoProducts as AuthProvider;
use GuzzleHttp\Psr7\Request;
use League\OAuth2\Client\Token\AccessTokenInterface;

trait OAuthAuthorisationServer
{
    /**
     * @var AuthProvider
     */
    protected $authProvider;

    /**
     * @var string $clientId
     */
    protected $clientId;

    /**
     * @var string $clientSecret
     */
    protected $clientSecret;

    public function authoriseRequest(Request $request): Request
    {
        $accessToken = $this->getAuthToken();

        $updatedRequest = $request->withHeader("Authorization", "Bearer " . $accessToken->getToken());

        return $updatedRequest;
    }

    protected function getAuthProvider()
    {
        if (!is_null($this->authProvider)) {
            return $this->authProvider;
        }

        return $this->authProvider = new AuthProvider(
            [
                "clientId" => $this->clientId,
                "clientSecret" => $this->clientSecret
            ]
        );
    }

    /**
     * @throws \League\OAuth2\Client\Provider\Exception\IdentityProviderException
     */
    private function getAuthToken(): AccessTokenInterface
    {
        return $this->getAuthProvider()->getAccessToken("client_credentials");
    }
}
