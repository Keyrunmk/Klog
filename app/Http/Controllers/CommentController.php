<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\CommentService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends BaseController
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function store(Post $post, Request $request): JsonResponse
    {
        try {
            $this->commentService->create($post, $request);
        } catch (Exception $e) {
            return $this->errorResponse($e->getCode(), $e->getMessage());
        }

        return $this->successResponse("Commented successfully");
    }
}
