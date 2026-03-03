<?php

namespace App\Exceptions;

use Exception;

class BusinessLogicException extends Exception
{
    protected $message;
    protected $statusCode;

    public function __construct($message = "Business Logic Error", $statusCode = 400)
    {
        parent::__construct($message);
        $this->statusCode = $statusCode;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
