<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
// use InvalidArgumentException;

class PassportCallbackHandler extends Controller
{
    public function __invoke(Request $request)
    {
        // $state = Session::get("state");
        // dd($state);

        // throw_unless(
        //     strlen($state) > 0 && $state === $request->state,
        //     InvalidArgumentException::class
        // );

        $response = Http::asForm()->post("http://127.0.0.1:8001/oauth/token", [
            "grant_type" => "authorization_code",
            "client_id" => "1",
            "client_secret" => "wE5FvKDAr6sV4LSMM4OpSea8vOLdpL4Uuk7VDdCB",
            "redirect_uri" => "http://127.0.0.1:8000/callback",
            "code" => $request->code,
        ]);

        return $response->json();
    }
}
