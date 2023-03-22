<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeemDetailResource;
use App\Http\Resources\TeemResource;
use App\Models\Teem;
use Illuminate\Http\Request;

class TeemController extends Controller
{
    public function index(){
        $teems = Teem::all();
        // return response()->json($teem);
        return TeemResource::collection($teems);
    }
    
    public function show($id){
        $teem = Teem::findOrFail($id);
        return new TeemDetailResource($teem);
    }
}
