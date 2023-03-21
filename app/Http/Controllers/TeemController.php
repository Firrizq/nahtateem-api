<?php

namespace App\Http\Controllers;

use App\Http\Resources\TeemResource;
use App\Models\Teem;
use Illuminate\Http\Request;

class TeemController extends Controller
{
    public function index(){
        $teem = Teem::all();
        // return response()->json($teem);
        return TeemResource::collection($teem);
    }
}
