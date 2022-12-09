<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Services\Admin\AuthenticationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminController extends BaseController
{
    protected AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function register(Request $request): JsonResponse|JsonResource
    {
        try {
            $data = $this->authenticationService->register($request);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), (int) $e->getCode());
        }

        return new AdminResource($data["admin"], $data["token"]);
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $token = $this->authenticationService->login($request);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), (int) $e->getCode());
        }

        return $this->successResponse($token);
    }

    public function logout(): JsonResponse
    {
        try {
            $this->authenticationService->logout();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->successResponse("Logged out successfully");
    }

    public function destroy(int $admin_id): JsonResponse
    {
        try {
            $this->authenticationService->delete($admin_id);
        } catch (Exception $e) {
            return $this->errorResponse("Only owners can remove admins", (int) $e->getCode());
        }

        return $this->successResponse("Admin deleted successfully");
    }
}
