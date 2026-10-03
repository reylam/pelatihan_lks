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

    public function login(Request $request){
        $auth = Auth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ]);  // Hasil nya bakal true or false

        if(!$auth){
            return response()->json([
                "message" => "email or password incorrect!" //email atau password salah
            ],401);
        } // false -> true, true -> false

        $user = Auth::user(); //user login
        $token = $user->createToken("token")->plainTextToken; // membuat token

        return response()->json([
            "message" => "Login Sucessfull",
            "user" => $user, // mengambil data user
            "token" => $token // mengambil token
        ]);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "Logout Sucessfull"
        ]);
    }

    public function me(){
        $user = Auth::user();
        return response()->json([
            "user" => $user,
            "category" => $user->categories
        ]);
    }
}
