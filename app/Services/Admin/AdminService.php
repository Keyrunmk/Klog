<?php

namespace App\Services\Admin;

use App\Contracts\AdminContract;
use App\Http\Resources\BaseResource;
use App\Models\PostReport;
use App\Repositories\AdminRepository;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AdminService
{
    public AdminRepository $adminRepository;

    public function __construct(AdminContract $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function adminRegister(array $attributes): mixed
    {
        $admin = $this->adminRepository->createAdmin($attributes);

        try {
            $token = Auth::guard("admin-api")->login($admin);
        } catch (JWTException $e) {
            return response()->json(["message" => $e->getMessage()]);
        }

        return [
            "admin" => $admin,
            "token" => $token,
        ];
    }

    public function adminLogin(array $attributes): JsonResource|array
    {
        try {
            $token = Auth::guard("admin-api")->attempt($attributes);
        } catch (JWTException $e) {
            return new BaseResource(["message" => $e->getMessage()]);
        }

        if (!$token) {
            return new BaseResource([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
        };

        return [
            "user" => Auth::guard("admin-api")->user(),
            "token" => $token,
        ];
    }

    public function adminLogout()
    {
        try {
            Auth::guard("admin-api")->logout();
        } catch (JWTException $e) {
            return new BaseResource(["message" => $e->getMessage()]);
        }
    }


    public function showReports()
    {
        return PostReport::all();
    }

    public function managerRegister(array $attributes): mixed
    {
        $admin = $this->adminRepository->createAdmin($attributes);

        return $admin;
    }

    public function editorRegister(array $attributes): mixed
    {
        $editor = $this->adminRepository->createAdmin($attributes);

        return $editor;
    }
}
