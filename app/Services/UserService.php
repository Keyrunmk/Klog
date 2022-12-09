<?php

namespace App\Services;

use App\Contracts\UserContract;
use App\Enum\UserStatusEnum;
use App\Exceptions\WebException;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Validations\UserLogin;
use App\Validations\UserRegister;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class UserService
{
    public UserRepository $userRepository;
    public UserRegister $validateRegister;
    public UserLogin $validateLogin;

    public function __construct(UserContract $userRepository, UserRegister $validateRegister, UserLogin $validateLogin)
    {
        $this->userRepository = $userRepository;
        $this->validateRegister = $validateRegister;
        $this->validateLogin = $validateLogin;
    }

    public function register(Request $request): User
    {
        $attributes = $this->validateRegister->validate($request);
        $attributes["password"] = Hash::make($attributes["password"]);

        try {
            $role = Role::where("slug", "user")->first();
            $attributes = array_merge($attributes, [
                "role_id" => $role->id,
            ]);
            $user = $this->userRepository->create($attributes);
            $this->userRepository->setLocation($user);
        } catch (Exception $e) {
            throw $e;
        }

        return $user;
    }

    public function login(Request $request): string
    {
        $attributes = $this->validateLogin->validate($request);

        try {
            $user = $this->userRepository->findWhere($attributes["email"], UserStatusEnum::Active);
            if (!$user) {
                throw new WebException("Please, verify your email", 403);
            }
            $token = Auth::attempt($attributes);
        } catch (JWTException $e) {
            throw $e;
        }

        if (!$token) {
            throw new Exception("Failed to authenticate", 500);
        };

        return $token;
    }

    public function logout(): void
    {
        try {
            Auth::guard("api")->logout();
        } catch (JWTException $e) {
            throw $e;
        }
    }

    public function refreshToken(): string
    {
        try {
            $newToken = Auth::refresh();
        } catch (JWTException $e) {
            throw $e;
        }

        return $newToken;
    }
}