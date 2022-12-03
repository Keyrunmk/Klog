<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdminResource;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function __invoke(Request $request)
    {
        $attributes = $request->validate([
            "first_name" => ["required", "string"],
            "last_name" => ["required", "string"],
            "username" => ["required","string"],
            "email" => ["required","email"],
            "password" => ["required","string","min:8","max:255"],
        ]);

        $data = $this->adminService->adminRegister($attributes);

        return new AdminResource($data["admin"], $data["token"]);
    }
}
