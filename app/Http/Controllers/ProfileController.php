<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show(Profile $profile)
    {
        return new ProfileResource($profile);
    }

    public function update()
    {
        $attributes = request()->validate([
            "title" => ["nullable", "string"],
            "description" => ["nullable", "string"],
            "url" => ["nullable", "url"]
        ]);

        $profile = Auth::user()->profile;

        $profile->update($attributes);

        return new ProfileResource($profile);
    }
}
