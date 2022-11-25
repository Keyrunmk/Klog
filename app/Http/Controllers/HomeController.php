<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsCollection;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function index()
    {
        $location = auth()->user()->location->first();
        $posts = $location->posts()->get();

        $userTags = auth()->user()->tags()->get();

        foreach ($userTags as $tag) {
            $posts->add($tag->posts);
        }

        return new PostsCollection($posts);
    }

    public function store(User $user)
    {
        $attributes = request()->validate([
            "name" => ["required", "string"],
        ]);

        $tag = $user->tags()->create($attributes);

        return response()->json([
            "status" => "success",
            "tag_id" => $tag->id,
            "tag" => $tag->name,
        ]);
    }
}
