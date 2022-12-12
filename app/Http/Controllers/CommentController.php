<?php

namespace App\Http\Controllers;

use App\Exceptions\ForbiddenException;
use App\Models\Comment;
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

    public function delete(Post $post, Comment $comment): JsonResponse
    {
        try {
            $this->commentService->destroy($post, $comment);
        } catch(ForbiddenException $e) {
            return $this->errorResponse("You cannot delete this comment", (int) $e->getCode());
        }catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), (int) $e->getCode());
        }

        return $this->successResponse("Comment id: $comment->id deleted.");
    }
}
