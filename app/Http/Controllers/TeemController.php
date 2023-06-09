<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeemDetailResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\TeemResource;
use Illuminate\Support\Facades\Storage;
use App\Models\Teem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TeemController extends Controller
{
    public function index(){
        $teems = Teem::all();
        // return response()->json($teem);
        return TeemDetailResource::collection($teems -> loadMissing('writer:id,username'));
    }
    
    public function show($id){
        $teem = Teem::with('writer:id,username','comments.replies')->findOrFail($id);
        $comments = $teem->comments;

        return new TeemDetailResource($teem, CommentResource::collection($comments));
    }
    
    public function store(Request $request){
        $request -> validate([
            'teems_content' => 'required',

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
            $fileName = $this->generateRandomString();
            $image = $fileName. '.' .$extension;

            Storage::putFileAs('image', $request->file, $image);

        }

        $request['image'] = $image;

        $request['author'] = Auth::user()->id;

        $teem = Teem::create($request->all());
        return new TeemDetailResource($teem -> loadMissing('writer:id,username', 'comments:id,teem_id,user_id,comment'));
    }

    public function update(Request $request, $id){
        $request -> validate([
            'teems_content' => 'required',
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
            $fileName = $this->generateRandomString();
            $image = $fileName. '.' .$extension;

            Storage::putFileAs('image', $request->file, $image);

        }

        $request['image'] = $image;


        // return response()->json('success');

        $teem = Teem::findOrFail($id);
        $teem->update($request->all());

        return new TeemDetailResource($teem -> loadMissing('writer:id,username'));
    }

    public function delete($id){
        $teem = Teem::findOrFail($id);
        $teem->delete();

        return response()->json([
            'message' => 'successfully deleted',
        ]);
    }

    function generateRandomString($length = 15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
