<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
        Cache::flush();
        return $this->successResponse($token);
    }

    public function logout(): JsonResponse
    {
        $this->userService->logout();
        return $this->successResponse("Logged out successfully");
    }

    public function refreshToken(): JsonResponse
    {
        $newToken = $this->userService->refreshToken();

        return $this->successResponse($newToken);
    }
}
