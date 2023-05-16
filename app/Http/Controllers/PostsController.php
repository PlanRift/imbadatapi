<?php

namespace App\Http\Controllers;

use App\Http\Resources\postDetailResource;
use App\Http\Resources\PostsResource;
use App\Models\posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only('store', 'update', 'delete');
        $this->middleware(['pemilik-news'])->only('update', 'delete');
    }
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

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'news_content' => 'required'
        ]);

        $post = posts::create([
            'title' => $request->input('title'),
            'news_content' => $request->input('news_content'),
            'author' => Auth::user()->id
        ]);

        return new postDetailResource($post->loadMissing('writer'));

    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'news_content' => 'required|string'
        ]);

        $post = posts::findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('writer'));
    }

    public function delete($id)
    {
        $post = posts::findOrFail($id);
        $post->delete();

        return response()->json([
            'message' => 'your post has been deleted'
        ]);
    }
}