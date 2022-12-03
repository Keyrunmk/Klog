<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\BaseResource;
use App\Http\Resources\LoginResource;
use App\Services\Admin\AdminService;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginController extends Controller
{
    protected AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
        $this->middleware("auth:admin-api")->only("logout");
    }

    public function login(LoginRequest $request): JsonResource
    {
        $attributes = $request->validated();

        $data = $this->adminService->adminLogin($attributes);

        return new LoginResource($data["user"], $data["token"]);
    }

    public function logout(): JsonResource
    {
        $this->adminService->adminLogout();

        return new BaseResource([
            "status" => "Logged out successfully",
        ]);
    }
}
