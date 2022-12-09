<?php

namespace App\Services\Admin;

use App\Contracts\AdminContract;
use App\Exceptions\ForbiddenException;
use App\Models\Role;
use App\Repositories\AdminRepository;
use App\Validations\AdminLogin;
use App\Validations\AdminRegister;
use Exception;
use Illuminate\Http\Request;
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

    public function register(Request $request): array
    {
        if (auth()->guard("admin-api")->user()->cannot("create", Admin::class)) {
            throw new ForbiddenException("Only owners can create admins");
        }

        $attributes = $this->validateRegister->validate($request);
        $attributes["password"] = Hash::make($attributes["password"]);

        try {
            $role = Role::where("slug", "admin")->first();
            $attributes = array_merge($attributes, [
                "role_id" => $role->id,
            ]);

            $admin = $this->adminRepository->create($attributes);
            $token = Auth::guard("admin-api")->login($admin);
        } catch (JWTException $e) {
            throw $e;
        }

        return [
            "admin" => $admin,
            "token" => $token,
        ];
    }

    public function login(Request $request): string
    {
        $attributes = $this->validateLogin->validate($request);
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

    public function delete(int $admin_id): void
    {
        if (auth()->guard("admin-api")->user()->cannot("create", Admin::class)) {
            throw new ForbiddenException("Only owners can remove admins");
        }

        try {
            $this->adminRepository->delete($admin_id);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
