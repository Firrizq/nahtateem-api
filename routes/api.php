<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\TeemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('/teems', [TeemController::class, 'index']);
    Route::get('/teems/{id}', [TeemController::class, 'show']);
    Route::post('/create', [TeemController::class, 'store']);
    Route::patch('/edit-teems/{id}', [TeemController::class, 'update'])->middleware('post.owner');

    Route::get('/logout', [AuthenticationController::class, 'logout']);
    Route::get('/profile', [AuthenticationController::class, 'profile']);
});

Route::post('/login', [AuthenticationController::class, 'login']);