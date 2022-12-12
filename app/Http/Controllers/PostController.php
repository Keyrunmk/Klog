<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsCollection;
use App\Models\Post;
use App\Services\PostService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
        $this->middleware("can:update,post")->only("update");
    }

    public function index(int $user_id): JsonResponse
    {
        try {
            $posts = $this->postService->index($user_id);
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }

        return $this->successResponse(message: "Posts if user id: $user_id", data: new PostsCollection($posts));
    }

    public function show(Post $post): JsonResponse
    {
        try {
            return $this->successResponse(message: "Post fetched", data: new PostResource($post));
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), (int) $exception->getCode());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $post = $this->postService->store($request);
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }

        return $this->successResponse(message: "Post stored", data: new PostResource($post));
    }

    public function update(int $post_id, Request $request): JsonResponse
    {
        try {
            $post = $this->postService->update($post_id, $request);
        } catch (NotFoundException $exception) {
            return $this->errorResponse("No post with post id: $post_id", (int) $exception->getCode());
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }

        return $this->successResponse(message: "post id: $post_id updated", data: new PostResource($post));
    }

    public function destroy(int $post_id): JsonResponse
    {
        try {
            $this->postService->delete($post_id);
        } catch (NotFoundException $exception) {
            return $this->errorResponse("No post with id: $post_id", (int) $exception->getCode());
        } catch (Exception $exception) {
            return $this->errorResponse($exception->getMessage(), $exception->getCode());
        }

        return $this->successResponse("Post deleted successfully");
    }
}
