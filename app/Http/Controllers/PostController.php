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
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostController extends BaseController
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(int $user_id): ResourceCollection|JsonResponse
    {
        try {
            $posts = $this->postService->index($user_id);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return new PostsCollection($posts);
    }

    public function show(Post $post): JsonResource|JsonResponse
    {
        try {
            return new PostResource($post);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), (int) $e->getCode());
        }
    }

    public function store(Request $request): JsonResource|JsonResponse
    {
        try {
            $post = $this->postService->store($request);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return new PostResource($post);
    }

    public function update(int $post_id, Request $request): JsonResource|JsonResponse
    {
        try {
            $post = $this->postService->update($post_id, $request);
        } catch(NotFoundException $e) {
            return $this->errorResponse("No post with post id: $post_id", (int) $e->getCode());
        }catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return new PostResource($post);
    }

    public function destroy(int $post_id): JsonResource|JsonResponse
    {
        try {
            $this->postService->delete($post_id);
        } catch (NotFoundException $e) {
            return $this->errorResponse("No post with id: $post_id", (int) $e->getCode());
        }catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }

        return $this->successResponse("Post deleted successfully");
    }
}
