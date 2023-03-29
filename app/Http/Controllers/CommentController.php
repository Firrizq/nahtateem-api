<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function reply(Request $request, Comment $comment)
{
    $attributes = $request->validate([
        'teem_id' => 'required|exists:teems,id',
        'comment' => 'required',
    ]);

    $reply = $comment->reply($attributes);

    // return response()->json([
    //     'message' => 'Komentar balasan berhasil ditambahkan.',
    //     'data' => $reply,
    // ]);
    return new CommentResource($comment->loadMissing(['replies:id']));
}

    public function store(Request $request){
    
        $request->validate([
            'teem_id' => 'required|exists:teems,id',
            'comment' => 'required',
            'parent_id' => 'nullable',
        ]);

        $image = null;
        $validextension = ['jpg', 'jpeg', 'png', 'mp4'];
        $extension = $request->file->extension();
        
        if(!in_array($extension, $validextension)){
            return response()->json([
                "Supported file : .jpg .jpeg .png .mp4"
            ]);
        }
        
        if ($request -> file) {
            $fileName = $this->randomstring();
            $image = $fileName. '.' .$extension;

            Storage::putFileAs('image', $request->file, $image);

        }

        $request['image'] = $image;

        $request['user_id'] = Auth::user()->id;

        $comment = Comment::create($request->all());

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

    function randomstring($length = 15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
