<?php

use App\Http\Controllers\Admin\AdminController;
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

Route::get("/custom", function () {
    return response()->json([
        "message" => "yo man ! u need to login",
    ]);
})->name("login");

//login and registration
Route::post("login", [AdminController::class, "login"]);
Route::post("logout", [AdminController::class, "logout"])->middleware("auth:admin-api");

Route::middleware("auth:admin-api", "adminRoute:admin")->group(function () {
    Route::post("register", [AdminController::class, "register"]);
    Route::delete("{admin_id}", [AdminController::class, "destroy"]);

    //categories
    Route::prefix("category")->group(function () {
        Route::post("", [CategoryController::class, "store"]);
        Route::patch("{category_id}", [CategoryController::class, "update"]);
        Route::get("{category_id}", [CategoryController::class, "show"]);
        Route::delete("{category_id}", [CategoryController::class, "destroy"]);
    });
});
