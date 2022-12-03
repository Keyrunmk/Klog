<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\TagService;

class TagController extends Controller
{
    protected TagService $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

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