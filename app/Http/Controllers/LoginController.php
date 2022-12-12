<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class LoginController extends BaseController
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->middleware("guest:api")->only("login");
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $token = $this->userService->login($request);
        } catch (NotFoundException $exception) {
            return $this->errorResponse("Please register first", (int) $exception->getCode());
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }

        Cache::flush();
        return $this->successResponse($token);
    }

    public function logout(): JsonResponse
    {
        try {
            $this->userService->logout();
        } catch (JWTException $exception) {
            return $this->errorResponse($exception->getMessage(), (int) $exception->getCode());
        }

        return $this->successResponse("Logged out successfully");
    }

    public function refreshToken(): JsonResponse
    {
        try {
            return $this->successResponse($this->userService->refreshToken());
        } catch (JWTException $exception) {
            return $this->errorResponse("Please, login first", (int) $exception->getCode());
        }
    }
}
