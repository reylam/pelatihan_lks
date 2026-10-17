<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::get("/", function(){
    return response()->json([
        "message" => "Hello BRO"
    ],200);
});

Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);
Route::post("/logout", [AuthController::class, "logout"])->middleware("auth:sanctum");
Route::get("/me", [AuthController::class, "me"])->middleware("auth:sanctum");

Route::post("/category", [CategoryController::class, "store"])->middleware("auth:sanctum");
Route::get("/category", [CategoryController::class, "index"]);
Route::get("/category/{id}", [CategoryController::class, "show"]);
Route::patch("/category/{id}", [CategoryController::class, "update"])->middleware("auth:sanctum");
Route::delete("category/{id}", [CategoryController::class, "destroy"])->middleware("auth:sanctum");

Route::get("/posts", [PostController::class, "index"]);
Route::post("/posts", [PostController::class, "store"])->middleware("auth:sanctum");
