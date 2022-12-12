<?php

namespace App\Http\Controllers;

use App\Contracts\TagContract;
use App\Models\Post;
use App\Repositories\TagRepository;
use Exception;
use Illuminate\Http\JsonResponse;

class TagController extends BaseController
{
    // todo
    protected TagRepository $tagRepository;

    public function __construct(TagContract $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function store(Post $post): JsonResponse
    {
        $attributes = request()->validate([
            "name" => ["required", "string"],
        ]);

        try {
            $post->tags()->create($attributes);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->successResponse("Tag created successfully");
    }
}
