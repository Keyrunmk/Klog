<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsCollection;
use App\Services\HomeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeController extends BaseController
{
    public HomeService $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index(): JsonResponse|JsonResource
    {
        try {
            $posts = $this->homeService->getPosts();
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), (int) $e->getCode());
        }

        return new PostsCollection($posts);
    }

    // public function store(User $user)
    // {
    //     $attributes = request()->validate([
    //         "name" => ["required", "string"],
    //     ]);

    //     $tag = $user->tags()->create($attributes);

    //     return response()->json([
    //         "status" => "success",
    //         "tag_id" => $tag->id,
    //         "tag" => $tag->name,
    //     ]);
    // }
}
