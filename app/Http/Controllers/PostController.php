<?php

namespace App\Http\Controllers;

use App\Exceptions\WebException;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsCollection;
use App\Models\Post;
use App\Services\PostService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(): ResourceCollection
    {
        try {
            $posts = $this->postService->index();
        } catch (Exception $e) {
            throw new WebException($e->getCode(), $e->getMessage());
        }

        return new PostsCollection($posts);
    }

    public function show(Post $post): JsonResource
    {
        return new PostResource($post);
    }

    public function store(Request $request): JsonResource
    {
        try {
            $post = $this->postService->store($request);
        } catch (Exception $e) {
            throw new WebException($e->getCode(), $e->getMessage());
        }

        return new PostResource($post);
    }

    public function update(Post $post, Request $request): JsonResource
    {
        try {
            $post = $this->postService->update($post, $request);
        } catch (Exception $e) {
            return new WebException($e->getCode(), $e->getMessage());
        }

        return new PostResource($post);
    }

    public function destroy(Post $post): JsonResource
    {
        try {
            $post = $this->postRepository->deletePost($post->id);
        } catch (Exception $e) {
            return new WebException($e->getCode(), $e->getMessage());
        }

        return new PostResource($post);
    }
}
