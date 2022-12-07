<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use App\Http\Resources\CommentResource;
use App\Models\Post;
use App\Services\CommentService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(Post $post, Request $request): JsonResource
    {
        try {
            $comments = $this->commentService->__invoke($post, $request);
        } catch (Exception $e) {
            throw new WebException($e->getCode(), $e->getMessage());
        }

        return new CommentResource($comments);
    }
}
