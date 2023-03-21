<?php

namespace App\Http\Controllers;

use App\Models\Teem;
use Illuminate\Http\Request;

class TeemController extends Controller
{
    public function index(){
        $teem = Teem::all();
        return response()->json($teem);
    }
}
