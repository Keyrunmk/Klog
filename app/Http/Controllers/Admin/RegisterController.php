<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AdminResource;
use App\Repositories\AdminRepository;
use App\Services\Admin\AdminService;

class RegisterController extends Controller
{
    public AdminRepository $adminRepository;
    public AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function __invoke(RegisterRequest $request)
    {
        $attributes = $request->validated();

        $data = $this->adminService->adminRegister($attributes);

        return new AdminResource($data["admin"], $data["token"]);
    }
}
