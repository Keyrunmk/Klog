<?php

namespace App\Services;

use App\Models\UserVerification;
use Illuminate\Http\Request;

class UserVerify
{
    public function __invoke(Request $request): string
    {
        $request = $request->validate([
            "token" => ["required","string"],
        ]);

        $verifyUser = UserVerification::where("token", $request["token"])->first();
        $message = "Sorry, your email cannot be verified.";

        if ($verifyUser) {
            $user = $verifyUser->user;
            $message = "Your email is already verified.";

            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
                $user->status = "active";
                $user->save();
                $message = "Your email is now verified.";
            }
        }

        return $message;
    }
}