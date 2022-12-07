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
        if (auth()->user ?? false) {
            $location = auth()->user()->location->first();
            $authPosts = $location->posts()->get();

            $userTags = auth()->user()->tags()->get();

            foreach ($userTags as $tag) {
                $authPosts->add($tag->posts);
            }
        }

        $posts = Post::latest()->filter(request(["search"]))->get();

        if ($authPosts ?? false) {
            $posts->add($authPosts);
        }

        return response()->json($posts);
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
