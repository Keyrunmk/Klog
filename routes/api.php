<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::get("user/error", function(){
    return response()->json([
        "message" => "Yo, something's wrong with what you gave me",
    ]);
})->name("user.error");

Route::get("/", [HomeController::class, "index"]);


// passport
Route::get("/redirect", function(Request $request){
    $state = Str::random(40);
    $request->session()->put("state", $state);

    $query = http_build_query([
        "client_id" => "1",
        "redirect_uri" => "http://127.0.0.1:8000/callback",
        "response_type" => "code",
        "scope" => "",
        "state" => $state,
        "prompt" => "consent",
    ]);

    return redirect('http://127.0.0.1:8001/oauth/authorize?'.$query);
});

//login and registration
Route::post("login", [LoginController::class, "login"]);
Route::post("register", RegisterController::class)->name("user.register");
Route::post("verify-email", AuthController::class)->middleware("auth:api");
Route::post("logout", [LoginController::class, "logout"])->middleware("auth:api");
Route::post("refresh", [LoginController::class, "refreshToken"])->middleware("auth:api");

Route::middleware("auth:api-jwt")->group(function () {
    //profile
    Route::prefix("profile")->group(function () {
        Route::get("{profile}", [ProfileController::class, "show"])->middleware("can:view,profile");
        Route::patch("{profile}", [ProfileController::class, "update"])->middleware("can:update,profile");
    });

    //posts
    Route::prefix("post")->controller(PostController::class)->group(function () {
        Route::get("", "index");
        Route::post("", "store");
        Route::patch("{post}", "update")->middleware("can:update,post");
        Route::get("{post:slug}", "show")->middleware("can:view,post");
        Route::delete("{post:slug}", "destroy");

        // Report Post
        Route::post("{post:slug}/report", PostReportController::class);

        //comments
        Route::post("{post:slug}/comment", [CommentController::class, "store"]);
    });

    //tags
    Route::prefix("tag")->group(function () {
        Route::post("post/{post}", [TagController::class, "store"]);
        Route::post("user/{user}", [HomeController::class, "store"]);
    });
});
