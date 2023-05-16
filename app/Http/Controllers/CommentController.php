<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\comments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->middleware(['pemilik-comment'])->only('update', 'delete');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id' ,
            'comments_content' => 'required'
        ]);

        $request['user_id'] = Auth::user()->id;

        $comment = comments::create($request->all());

        return new CommentResource($comment);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'comments_content' => 'required|string'
        ]);

        $comment = comments::findOrFail($id);
        $comment->update($request->all());

        return new CommentResource($comment->loadMissing('commentator'));
    }

    public function delete($id){

        $comment = comments::findOrFail($id);
        $comment->delete();

        return response()->json([
            'message' => 'comment has been deleted'
        ]);
    }
}
