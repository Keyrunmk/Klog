<?php

namespace App\Services\Admin;

use App\Contracts\AdminContract;
use App\Http\Resources\BaseResource;
use App\Repositories\AdminRepository;
use App\Validations\AdminLogin;
use App\Validations\AdminRegister;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class AuthenticationService
{
    public AdminRepository $adminRepository;
    public AdminRegister $validateRegister;
    public AdminLogin $validateLogin;

    public function __construct(AdminContract $adminRepository, AdminRegister $validateRegister, AdminLogin $validateLogin)
    {
        $this->adminRepository = $adminRepository;
        $this->validateRegister = $validateRegister;
        $this->validateLogin = $validateLogin;
    }

    public function register(Request $request): mixed
    {
        $attributes = $this->validateRegister->run($request);
        $attributes["password"] = Hash::make($attributes["password"]);

        $admin = $this->adminRepository->create($attributes);
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

    public function login(Request $request): JsonResource|array
    {
        $attributes = $this->validateLogin->run($request);
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
            "admin" => Auth::guard("admin-api")->user(),
            "token" => $token,
        ];
    }

    public function logout()
    {
        try {
            Auth::guard("admin-api")->logout();
        } catch (JWTException $e) {
            return new BaseResource(["message" => $e->getMessage()]);
        }
    }
}