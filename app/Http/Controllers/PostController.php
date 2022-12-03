<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostsCollection;
use App\Models\Post;
use App\Services\PostService;
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
        $posts = $this->postService->index();

        return new PostsCollection($posts);
    }

    public function show(Post $post): JsonResource
    {
        return new PostResource($post);
    }

    public function store(PostRequest $request): JsonResource
    {
        $request = $request->validated();

        $post = $this->postService->store($request);

        return new PostResource($post);
    }

    public function update(Post $post, PostRequest $request): JsonResource
    {
        $attributes = $request->validated();

        $post = $this->postService->update($post, $attributes);

        return new PostResource($post);
    }

    public function destroy(Post $post): JsonResource
    {
        $this->postService->delete($post);

        return new PostResource($post);
    }
}
