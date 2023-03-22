<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeemDetailResource;
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
        return TeemDetailResource::collection($teems -> loadMissing('writer:id,username', 'comments:id,teem_id,user_id,comment_content'));
    }
    
    public function show($id){
        $teem = Teem::with('writer:id,username')->findOrFail($id);
        return new TeemDetailResource($teem);
    }
    
    public function store(Request $request){
        $request -> validate([
            'teems_content' => 'required',

        ]);

        $image = null;

        if ($request -> file) {
            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            $image = $fileName. '.' .$extension;
            Storage::putFileAs('image', $request->file, $image);

        }

        // return response()->json('sudah dapat digunakan');
        $request['image'] = $image;

        // return response()->json('sudah dapat digunakan');

        $request['author'] = Auth::user()->id;

        $teem = Teem::create($request->all());
        return new TeemDetailResource($teem -> loadMissing('writer:id,username', 'comments:id,teem_id,user_id,comment_content'));
    }

    public function update(Request $request, $id){
        $request -> validate([
            'teems_content' => 'required',
        ]);

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
