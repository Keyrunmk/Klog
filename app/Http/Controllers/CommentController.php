<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(Post $post, CommentRequest $request): JsonResource
    {
        $attributes = $request->validated();

        $comments = $this->commentService->__invoke($post, $attributes);

        return new CommentResource($comments);
    }
}
