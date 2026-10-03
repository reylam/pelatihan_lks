<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function store(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            "name" => "min:3|unique:categories,name",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Validator Detected",
                "errors" => $validator->errors()
            ], 400);
        }

        $category = Category::create([
            "name" => $request->name,
            "user_id" => $user->id
        ]);

        return response()->json([
            "message" => "Created Category Successful",
            "category" => $category
        ]);
    }
}
