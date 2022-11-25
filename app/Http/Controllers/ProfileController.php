<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    protected $profileRepository;

    public function show(Profile $profile)
    {
        return new ProfileResource($profile);
    }

    public function update(Profile $profile)
    {
        $attributes = request()->validate([
            "title" => ["nullable", "string"],
            "description" => ["nullable", "string"],
            "url" => ["nullable", "url"],
            "image" => ["nullable", "image"],
        ]);

        $user = auth()->user();
        $profile = $user->profile;

        $profile->update([
            "title" => $attributes["title"],
            "description" => $attributes["description"],
            "url" => $attributes["url"]
        ]);

        $imagePath = request("image")->store("uploads", "public");
        $image = Image::make(public_path("storage/$imagePath"))->fit(2000, 2000);
        $image->save();

        if (!$user->image()->update(["path" => $imagePath])){
            $user->image()->create(["path" => $imagePath]);
        }

        return new ProfileResource($profile);
    }
}
