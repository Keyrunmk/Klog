<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsCollection;
use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;
use App\Services\HomeService;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeController extends Controller
{
    public HomeService $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index(): JsonResource
    {
        $posts = $this->homeService->getPosts();

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
