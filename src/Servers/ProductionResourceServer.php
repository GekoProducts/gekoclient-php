<?php

namespace GekoProducts\HttpClient\Servers;

use GuzzleHttp\Psr7\Request;

class ProductionResourceServer extends ResourceServer {

    protected $address = "https://api.gekoproducts.co.uk";

}
