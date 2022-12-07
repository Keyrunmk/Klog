<?php

namespace App\Http\Controllers;

use App\Contracts\TagContract;
use App\Exceptions\WebException;
use App\Models\Post;
use App\Repositories\TagRepository;
use Exception;

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

        try {
            $tag = $post->tags()->create($attributes);
        } catch (Exception $e) {
            throw new WebException($e->getCode(), $e->getMessage());
        }

        return response()->json([
            "status" => "success",
            "tag_id" => $tag->id,
            "tag" => $tag->name,
        ]);
    }
}