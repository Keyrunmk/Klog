<?php

namespace App\Listeners;

use App\Http\Resources\BaseResource;
use App\Mail\VerifyEmail;
use App\Models\UserVerification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailVerification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $token = Str::random(6);

        UserVerification::create([
            "user_id" => $event->user->id,
            "token" => $token,
        ]);

        Mail::to($event->user->email)->send(new VerifyEmail($token));

        return new BaseResource(["status" => "Check your mail for verification."]);
    }
}
