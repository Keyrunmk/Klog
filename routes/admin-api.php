<?php

use App\Http\Controllers\Admin\EditorController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\ManagerController;
use App\Http\Controllers\Admin\ModeratorController;
use App\Http\Controllers\Admin\RegisterController;
use App\Http\Controllers\CategoryController;
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

Route::get("/custom", function(){
    return response()->json([
        "message" => "yo man ! u need to login",
    ]);
})->name("login");

//login and registration
Route::post("login", [LoginController::class, "login"]);
Route::post("logout", [LoginController::class, "logout"])->middleware("auth:admin-api");
Route::post("register", RegisterController::class);

Route::middleware("auth:admin-api")->group(function () {
    // Manager
    Route::prefix("manager")->group(function(){
        Route::post("", [ManagerController::class, "store"]);
        Route::get("{admin}", [ManagerController::class, "show"]);
    });

    // Editor
    Route::prefix("editor")->group(function(){
        Route::post("", [EditorController::class, "store"]);
        Route::get("reports", [EditorController::class, "show"]);
        // show user some message using listener when their post is deleted
        Route::delete("post/{post}", [EditorController::class, "delete"]);
        Route::post("user/{user}", [EditorController::class, "warn"]);
    });

    // Moderator
    Route::prefix("moderator")->group(function(){
        Route::post("", [ModeratorController::class, "store"]);
    });

    //categories
    Route::prefix("category")->group(function () {
        Route::post("", [CategoryController::class, "store"]);
        Route::patch("{category}", [CategoryController::class, "update"]);
        Route::get("{category:slug}", [CategoryController::class, "show"]);
        Route::delete("{category:slug}", [CategoryController::class, "destroy"]);
    });
});
