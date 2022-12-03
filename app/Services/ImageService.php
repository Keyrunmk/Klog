<?php

namespace App\Services;

use Intervention\Image\Facades\Image;

class ImageService
{
    public function processImage(): string
    {
        $imagePath = request("image")->store("uploads", "public");
        $image = Image::make(public_path("storage/$imagePath"))->fit(2000, 2000);
        $image->save();

        return $imagePath;
    }
}
