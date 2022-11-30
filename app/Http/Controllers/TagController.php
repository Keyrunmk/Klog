<?php

namespace App\Http\Controllers;

use App\Contracts\TagContract;
use App\Models\Post;
use App\Repositories\TagRepository;

class TagController extends Controller
{
    protected TagRepository $tagRepository;

    public function __construct(TagContract $tagRepository)
    {
        $this->tagRepository = $tagRepository;
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