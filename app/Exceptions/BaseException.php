<?php

namespace App\Exceptions;

use App\Http\Resources\BaseResource;
use Exception;
use Illuminate\Http\JsonResponse;

abstract class BaseException extends Exception
{
    public function render()
    {
        return response()->json([
            "code" => $this->code,
            "message" => $this->message,
        ], $this->code);
    }
}
