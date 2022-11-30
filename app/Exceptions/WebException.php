<?php

namespace App\Exceptions;

use Exception;

class WebException extends BaseException
{
    public function __construct(int $errorCode, string $errorMessage)
    {
        $errorCode = ($errorCode < 100 || $errorCode > 500) ? 500 : $errorCode;
        $this->code = $errorCode;
        $this->message = $errorMessage;
    }
}