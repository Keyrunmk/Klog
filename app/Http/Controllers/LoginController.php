<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only(['email', 'password']);

        try {
            $token = Auth::attempt($credentials);
        } catch (JWTException $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ]);
        }

        $user = Auth::user();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer'
            ],
        ]);
    }



    public function logout()
    {
        try {
            Auth::logout();
        } catch (JWTException $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully',
        ]);
    }

    public function refresh()
    {
        try {
            $newToken = Auth::refresh();
        } catch (JWTException $e) {
            return response()->json(['message' => $e->getMessage()]);
        }

        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorization' => [
                'token' => $newToken,
                'type' => 'bearer'
            ],
        ]);
    }
}
