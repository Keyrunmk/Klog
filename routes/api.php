<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
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

Route::get("/", [HomeController::class, "index"]);

//login and registration
Route::post("login", [AuthController::class, "login"])->middleware("guest");
Route::post("register", [AuthController::class, "register"])->middleware("guest");
Route::post("logout", [AuthController::class, "logout"])->middleware("auth:api");
Route::post("refresh", [AuthController::class, "refresh"])->middleware("auth:api");

//profile
Route::prefix("profile")->middleware("auth:api")->group(function () {
    Route::get("{profile}", [ProfileController::class, "show"])->middleware("can:view,profile");
    Route::patch("{profile}", [ProfileController::class, "update"])->middleware("can:update,profile");
});

//posts
Route::prefix("post")->middleware("auth:api")->group(function () {
    Route::post("", [PostController::class, "store"]);
    Route::patch("{post}", [PostController::class, "update"])->middleware("can:update,post");
    Route::get("{post:slug}", [PostController::class, "show"])->middleware("can:show,post");
    Route::delete("{post:slug}", [PostController::class, "destroy"]);

    //comments
    Route::post("{post:slug}/comment", [CommentController::class, "store"]);
});

//categories
Route::prefix("category")->middleware("auth:api")->group(function () {
    Route::post("", [CategoryController::class, "store"]);
    Route::patch("{category}", [CategoryController::class, "update"]);
    Route::get("{category:slug}", [CategoryController::class, "show"]);
    Route::delete("{category:slug}", [CategoryController::class, "destroy"]);
});

//create tags
Route::post("post/{post}/tag", [TagController::class, "store"])->middleware("auth:api");
