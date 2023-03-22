<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeemDetailResource;
use App\Http\Resources\TeemResource;
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
}
