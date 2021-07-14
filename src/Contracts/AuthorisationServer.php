<?php

namespace GekoProducts\HttpClient\Contracts;

use GuzzleHttp\Psr7\Request;

interface AuthorisationServer {

    public function authoriseRequest(Request $request);
}
