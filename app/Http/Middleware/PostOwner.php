<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Teem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PostOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentuser = Auth::user();
        $teem = Teem::findOrFail($request->id);

        if($teem->author != $currentuser->id){
            return response()->json([
                'message' => 'Data not found :(',
            ]);
        }

        return $next($request);
    }
}
