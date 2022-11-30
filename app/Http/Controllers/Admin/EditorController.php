<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Post;
use App\Models\User;
use App\Services\Admin\AdminService;
use Illuminate\Http\Request;

class EditorController extends Controller
{
    public AdminService $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function show()
    {
        $reports = $this->adminService->showReports();

        return response()->json($reports);
    }

    public function store(RegisterRequest $request)
    {
        $attributes = $request->validated();

        $data = $this->adminService->editorRegister($attributes);

        return response()->json([
            "manager" => $data,
        ]);
    }

    public function delete(Post $post)
    {
        $post->delete();

        return response()->json([
            "status" => "Post delete successfully",
        ]);
    }

    public function warn(User $user, Request $request)
    {
        $user->status = "warned";

        $user->save();

        dd($user->status);
    }
}
