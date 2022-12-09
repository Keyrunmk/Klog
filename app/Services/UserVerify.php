<?php

namespace App\Services;

use App\Enum\UserStatusEnum;
use App\Exceptions\WebException;
use App\Models\User;
use App\Models\UserVerification;
use Illuminate\Http\Request;

class UserVerify
{
    public function verify(Request $request, User $user): string
    {
        $request = $request->validate([
            "token" => ["required", "string"],
        ]);

        $verifyUser = UserVerification::where("token", $request["token"])->where("user_id", $user->id)->first();

        if (!$verifyUser) {
            throw new WebException("Invalid token", 500);
        }

        $user = $verifyUser->user;
        $message = "Your email is already verified.";

        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
            $user->status = UserStatusEnum::Active;
            $user->save();
            $message = "Your email is now verified.";
        }

        return $message;
    }
}
