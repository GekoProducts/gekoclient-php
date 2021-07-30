<?php

namespace GekoProducts\HttpClient\Servers;

use GekoProducts\HttpClient\Contracts\AuthorisationServer;
use GekoProducts\HttpClient\Servers\Traits\OAuthAuthorisationServer;

class ProductionAuthorisationServer implements AuthorisationServer
{
    use OAuthAuthorisationServer;

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

}
