<?php

namespace App\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait CustomResponse
{
    public function errorResponse(string $message, int $responseCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $responseCode = ($responseCode < 100 || $responseCode > 500) ? 500 : $responseCode;

        return response()->json([
            "status" => "Failed",
            "message" => $message,
        ], $responseCode);
    }

    public function successResponse(string $message, int $responseCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            "status" => "success",
            "message" => $message,
        ], $responseCode);
    }
}
