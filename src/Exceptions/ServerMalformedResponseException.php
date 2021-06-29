<?php

namespace GekoProducts\HttpClient\Exceptions;

use Throwable;

class ServerMalformedResponseException extends \Exception {

    public $responseBody;

    public function __construct($responseBody, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->responseBody = $responseBody;

        parent::__construct($this->makeMessage(), $code, $previous);
    }

    private function makeMessage()
    {
        return "The Geko server returned a malformed response. Expected JSON.";
    }
}
