<?php

namespace App\Services\Admin;

use App\Contracts\AdminContract;
use App\Http\Resources\BaseResource;
use App\Repositories\AdminRepository;
use App\Validations\AdminLogin;
use App\Validations\AdminRegister;
use Illuminate\Http\JsonResponse;
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

        try {
            $admin = $this->adminRepository->create($attributes);
            $token = Auth::guard("admin-api")->login($admin);
        } catch (JWTException $e) {
            throw $e;
        }

        return $token;
    }

    public function login(Request $request): string
    {
        $attributes = $this->validateLogin->run($request);
        try {
            $token = Auth::guard("admin-api")->attempt($attributes);
        } catch (JWTException $e) {
            throw $e;
        }

        return $token;
    }

    public function logout(): void
    {
        try {
            Auth::guard("admin-api")->logout();
        } catch (JWTException $e) {
            throw $e;
        }
    }
}