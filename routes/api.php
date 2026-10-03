<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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

