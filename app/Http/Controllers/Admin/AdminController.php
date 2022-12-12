<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\BaseController;
use App\Http\Resources\AdminResource;
use App\Services\Admin\AuthenticationService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AdminController extends BaseController
{
    protected AuthenticationService $authenticationService;

    public function __construct(AuthenticationService $authenticationService)
    {
        $this->authenticationService = $authenticationService;
        $this->middleware("adminRole:create")->only(["register","destroy"]);
    }

    public function register(Request $request): JsonResponse|JsonResource
    {
        try {
            $data = $this->authenticationService->register($request);
        } catch (JWTException $e) {
            return $this->errorResponse("Failed to get token for admin id: ". $data["admin"]->id, (int) $e->getCode());
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), (int) $e->getCode());
        }

        return new AdminResource($data["admin"], $data["token"]);
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $token = $this->authenticationService->login($request);
        } catch (JWTException $e) {
            return $this->errorResponse("Invalid Credentials", (int) $e->getCode());
        }

        return $this->successResponse($token);
    }

    public function logout(): JsonResponse
    {
        try {
            $this->authenticationService->logout();
        } catch (JWTException $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->successResponse("Logged out successfully");
    }

    public function destroy(int $admin_id): JsonResponse
    {
        try {
            $this->authenticationService->delete($admin_id);
        } catch (ModelNotFoundException $e) {
            return $this->errorResponse("Failed to find the admin with id: $admin_id", (int) $e->getCode());
        } catch (Exception $e) {
            return $this->errorResponse("Failed to delete admin id: $admin_id", (int) $e->getCode());
        }

        return $this->successResponse("Admin id: $admin_id deleted successfully");
    }
}
