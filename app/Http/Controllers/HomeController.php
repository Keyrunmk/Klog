<?php

namespace App\Http\Controllers;

use App\facades\UserLocation;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsCollection;
use App\Models\Location;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $location = Location::where("location", UserLocation::getCountryName())->first();
        if (! $location) {
            $location = Location::create(["location" => UserLocation::getCountryName()]);
        }

        $posts = Post::where("location_id", $location->id)->get();

        return new PostsCollection($posts);
    }
}
