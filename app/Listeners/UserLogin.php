<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Http\Resources\BaseResource;
use App\Http\Resources\UserResource;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;

class UserLogin
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
        try {
            $token = Auth::login($event->user);
        } catch (JWTException $e) {
            return new BaseResource(["message" => $e->getMessage()]);
        }

        return new UserResource($event->user, $token);
    }
}
