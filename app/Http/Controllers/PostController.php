<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index(){
        $posts = Post::all();

        return response()->json([
            "message" => "Get all Post Received!",
            "data" => $posts
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
           "title" => "required|max:255",
           "content" => "required",
           "image" => "nullable|image|mimes:png,jpg,pneg,jpeg,pdf",
           "category_id" => "required",
        ]);

        if($validator->fails()){
            return response()->json([
                "message" => "Validation is failed",
                "errors" => $validator->errors()
            ],421);
        }

        // posts -> category, user itu hanya boleh menggunakan category yang hanya dia buat, selain itu dia bakal kena validasi
        $user_id = $request->user()->id;
        $category = Category::find($request->category_id);
        //$category = Category::where("id", $request->category_id)->first();

        if(!$category){
            return response()->json([
                "message" => "Category is NULL!"
            ],401);
        }

        if($category->user_id != $user_id){
            return response()->json([
                "message" => "user_id in category id is not match with request user_id",
            ]);
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            "user_id" => $request->user()->id
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'data' => $post->load('category')
        ], 201);
    }
}
