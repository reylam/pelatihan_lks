<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "email|unique:users,email",
            "password" => "min:8"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Validator Detected",
                "errors" => $validator->errors()
            ], 400);
        }

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        $token = $user->createToken("")->plainTextToken;
        return response()->json([
            "message" => "Register Successfull",
            "data" => $user,
            "token" => $token,
        ], 201);
    }
}
