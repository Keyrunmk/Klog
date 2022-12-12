<?php

namespace App\Services\Admin;

use App\Contracts\AdminContract;
use App\Exceptions\WebException;
use App\Models\Role;
use App\Repositories\AdminRepository;
use App\Validations\AdminLogin;
use App\Validations\AdminRegister;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
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

    public function register(Request $request): array
    {
        $attributes = $this->validateRegister->validate($request);
        $attributes["password"] = Hash::make($attributes["password"]);

        try {
            $role = Cache::remember("role-admin", 86400, function () {
                return Role::where("slug", "admin")->first();
            });

            $attributes = array_merge($attributes, [
                "role_id" => $role->id,
            ]);

            $admin = $this->adminRepository->create($attributes);
            $token = Auth::guard("admin-api")->login($admin);
            if (empty($token)) {
                throw new WebException("Failed to login", Response::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $exception) {
            throw $exception;
        }

        return [
            "admin" => $admin,
            "token" => $token,
        ];
    }

    public function login(Request $request): string
    {
        $attributes = $this->validateLogin->validate($request);

        $token =  Auth::guard("admin-api")->attempt($attributes);

        if (empty($token)) {
            throw new WebException("Invalid Credentials", Response::HTTP_UNAUTHORIZED);
        }

        return $token;
    }

    public function logout(): void
    {
        Auth::guard("admin-api")->logout();
    }

    public function delete(int $admin_id): void
    {
        $this->adminRepository->delete($admin_id);
    }
}
