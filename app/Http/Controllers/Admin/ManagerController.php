<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Models\Admin;
use App\Services\Admin\AdminService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagerController extends Controller
{
    public AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
        $this->middleware("role:page-admin")->only("store");
    }

    public function show(Admin $admin): JsonResource
    {
        return new AdminResource($admin);
    }

    public function store(Request $request)
    {
        $data = $this->adminService->managerRegister($request);

        return response()->json([
            "status" => "Manager created successfully",
            "manager" => $data,
        ]);
    }
}
