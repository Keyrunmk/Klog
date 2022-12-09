<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Oauth\CallbackController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware("auth:sanctum")->get("/user", function (Request $request) {
    return $request->user();
});

Route::get("/custom", function () {
    return response()->json([
        "message" => "Yo, something's wrong with what you gave me",
    ]);
})->name("login");

// passport
Route::get("/redirect", function (Request $request) {

    $query = http_build_query([
        "client_id" => "1",
        "redirect_uri" => "http://localhost/api/callback",
        "response_type" => "code",
        "scope" => "",
        "state" => "",
        "prompt" => "consent", // "none", "consent", or "login"
    ]);

    return redirect("http://localhost:3001/oauth/authorize?" . $query);
});

Route::get("callback", CallbackController::class);

// Home
Route::get("/", [HomeController::class, "index"]);

//login and registration
Route::post("login", [LoginController::class, "login"]);
Route::post("register", [RegisterController::class, "register"]);
Route::post("verify-email/{user}", [RegisterController::class, "verify"]);
Route::post("logout", [LoginController::class, "logout"])->middleware("auth:api");
Route::post("refresh", [LoginController::class, "refreshToken"])->middleware("auth:api");

Route::middleware("auth:api", "role:user", "verify:active")->group(function () {
    //profile
    Route::prefix("profile")->group(function () {
        Route::get("{profile_id}", [ProfileController::class, "show"]);
        Route::patch("{profile_id}", [ProfileController::class, "update"]);
        Route::post("{user}", [FollowController::class, "follow"]);
    });

    //posts
    Route::prefix("post")->controller(PostController::class)->group(function () {
        Route::get("user/{user_id}", "index");
        Route::post("", "store");
        Route::patch("{post_id}", "update")->middleware("can:update,post");
        Route::get("show/{post}", "show");
        Route::delete("{post_id}", "destroy");

        // Report Post
        Route::post("{post:slug}/report", [PostReportController::class, "report"]);

        //comments
        Route::post("{post:slug}/comment", [CommentController::class, "store"]);
    });

    //tags
    Route::prefix("tag")->group(function () {
        Route::post("post/{post}", [TagController::class, "store"]);
        // Route::post("user/{user}", [HomeController::class, "store"]);
    });
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Page Not Found. If error persists, contact info@klog.com'
    ], 404);
});
