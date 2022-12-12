<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Resources\BaseResource;
use App\Services\Admin\AuthenticationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginController extends BaseController
{
    protected AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
        // $this->middleware("guest:admin-api");
    }

    public function login(Request $request): JsonResponse
    {
        $token = $this->authenticationService->login($request);

        return $this->successResponse($token);
    }

    public function logout(): JsonResponse
    {
        try {
            $this->authenticationService->logout();
            return $this->successResponse("Logged out successfully");
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
