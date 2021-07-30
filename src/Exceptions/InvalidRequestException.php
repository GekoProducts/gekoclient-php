<?php

namespace GekoProducts\HttpClient\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Throwable;

class InvalidRequestException extends Exception
{
    /**
     * @var array $errors
     */
    private $errors;

    public function __construct(ResponseInterface $response, $message = "", $code = 0, Throwable $previous = null)
    {
        $message = $this->makeMessage($response);

        $this->setErrors($response);

        parent::__construct($message, $code, $previous);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function setErrors(ResponseInterface $response)
    {
        $body = $response->getBody();

        $data = json_decode($body, true);

        if ($data) {
            $this->errors = $data['errors'];
        }
    }

    private function makeMessage(ResponseInterface $response)
    {
        $body = $response->getBody();

        $data = json_decode($body, true);

        if ($data) {
            return $data['message'];
        }

        return "An unknown error occurred";
    }

}
