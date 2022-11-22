<?php

namespace App\Http\Controllers;

use App\Models\Post;

class TagController extends Controller
{
    public function store(Post $post)
    {
        $attributes = request()->validate([
            "name" => ["required", "string"],
        ]);

        $tag = $post->tags()->create($attributes);

        return response()->json([
            "status" => "success",
            "tag_id" => $tag->id,
            "tag" => $tag->name,
        ]);
    }
}
