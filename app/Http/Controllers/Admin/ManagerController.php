<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Admin;
use App\Services\Admin\AdminService;

class ManagerController extends Controller
{
    public AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function show(Admin $admin)
    {
        return response()->json([
            "moderator" => $admin
        ]);
    }

    public function store(RegisterRequest $request)
    {
        $attributes = $request->validated();

        $data = $this->adminService->managerRegister($attributes);

        return response()->json([
            "manager" => $data,
        ]);
    }
}
