<?php

namespace App\Exceptions;

use Exception;

class RepoException extends BaseException
{
    public Exception $exception;

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }

    public function status(): int
    {
        return $this->exception->getCode();
    }

    public function error(): string
    {
        return $this->exception->getMessage();
    }

    public function trace(): array
    {
        return $this->exception->getTrace();
    }
}