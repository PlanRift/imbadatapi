<?php

namespace App\Http\Controllers;

use App\Http\Resources\postDetailResource;
use App\Http\Resources\PostsResource;
use App\Models\posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
    {
        $posts = posts::all();
        // return response()->json(['data' => $posts]);
        return PostsResource::collection($posts);
    }

    public function show($id) {
        
        $post = posts::with('writer:id,username')->findOrFail($id);
        return new postDetailResource($post);
        // return response()->json(['data' => $post]);

    }

    public function show2($id) {
        
        $post = posts::findOrFail($id);
        return new postDetailResource($post);
        // return response()->json(['data' => $post]);

    }
}
