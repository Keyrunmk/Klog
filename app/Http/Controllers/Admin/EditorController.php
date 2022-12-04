<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        $this->middleware("permission:create-editor")->only("store");
    }

    public function show()
    {
        $reports = $this->adminService->showReports();

        return response()->json($reports);
    }

    public function store(Request $request)
    {
        $data = $this->adminService->editorRegister($request);

        return response()->json([
            "status" => "Editor created successfully",
            "editor" => $data,
        ]);
    }

    // public function delete(Post $post)
    // {
    //     $post->delete();

    //     return response()->json([
    //         "status" => "Post deleted successfully",
    //     ]);
    // }

    // public function warn(User $user, Request $request)
    // {
    //     $user->status = "warned";
    //     $user->save();

    //     dd($user->status);
    // }
}
