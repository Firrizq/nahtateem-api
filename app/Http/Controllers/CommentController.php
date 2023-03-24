<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function reply(Request $request, Comment $comment)
{
    $attributes = $request->validate([
        'comment' => 'required|string|max:1000',
    ]);

    $reply = $comment->reply($attributes);

    return response()->json([
        'message' => 'Komentar balasan berhasil ditambahkan.',
        'data' => $reply,
    ]);
}

    public function store(Request $request){
        $request->validate([
            'teem_id' => 'required|exists:teems,id',
            'comment' => 'required'
        ]);

        $request['user_id'] = auth()->user()->id;

        $comment = Comment::create($request->all());

        // return response()->json($comment);

        return new CommentResource($comment->loadMissing(['commentator:id,username']));
    }

    public function update(Request $request, $id){
        $request -> validate([
            'comment' => 'required'
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($request->only('comment'));

        return new CommentResource($comment->loadMissing(['commentator:id,username']));
    }


    public function delete($id){
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json([
            'message' => 'Delete Comment Success',
        ]);
    }
}
