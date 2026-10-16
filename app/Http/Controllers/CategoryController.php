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
            "name" => "required|min:3|unique:categories,name",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Validator Detected",
                "errors" => $validator->errors()
            ], 401);
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

    public function index(){
        $category = Category::all();

        return response()->json([
            "message" => "Get All Category Successfully",
            "categories" => $category
        ]);
    }

    public function show($id){
        $category = Category::find($id);

        if($category == NULL){
            return response()->json([
                "message" => "Get Category by id not found!"
            ],404);
        }

        return response()->json([
            "message" => "Get Category by id Successfuly!",
            "category" => $category
        ]);
    }

    public function update($id, Request $request){
        $category = Category::find($id);

        if($category == NULL){ // kalau categorynya not found
            return response()->json([
                "message" => "Get Category by id not found!"
            ],404);
        }

        if($category->user_id != Auth::user()->id){ // validasi membandingkan category yang kita ambil berdasarkan user jika berbeda dengan user yang login
            return response()->json([
                "message" => "Cannot update category!"
            ],401);
        }

        $validator = Validator::make($request->all(), [
            "name" => "required|min:3|unique:categories,name",
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Validator Detected",
                "errors" => $validator->errors()
            ], 401);
        }

        $updateCategory = $category->update([
            "name" => $request->name
        ]);

        return response()->json([
            "message" => "Updated category by id successfully!",
            "category" => $category
        ]);
    }

    public function destroy($id){
        $category = Category::find($id);

        if($category == NULL){ // kalau categorynya not found
            return response()->json([
                "message" => "Get Category by id not found!"
            ],404);
        }

        if($category->user_id != Auth::user()->id){ // validasi membandingkan category yang kita ambil berdasarkan user jika berbeda dengan user yang login
            return response()->json([
                "message" => "Cannot update category!"
            ],401);
        }

        $category->delete();

        return response()->json([
            "message" => "Delete category by successfully"
        ]);
    }
}
