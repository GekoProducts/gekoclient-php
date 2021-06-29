<?php

namespace GekoProducts\HttpClient\Exceptions;

use GuzzleHttp\Psr7\Response;
use Throwable;

class ServerResponseException extends \Exception {

    /**
     * @var Response
     */
    public $response;

    public function __construct(Response $response, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->response = $response;

        parent::__construct($this->makeHttpMessage(), $this->response->getStatusCode(), $previous);
    }

    private function makeHttpMessage()
    {
        return "A HTTP error occurred when communicating with the Geko server";
    }

}
