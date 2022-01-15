<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// -----------login route------------
Route::post('login',[AuthController::class,'login']);

// -------------log out----------------
Route::middleware(['auth:sanctum'])->group(function(){
    Route::get('logout',[AuthController::class,'logout']);
    Route::apiResource('posts',PostController::class);
    Route::get('posts/slug/{slug}',[PostController::class,'showBySlug']);
});

Route::get('/posts/delete/{post}',[PostController::class,'destroy']);
Route::post('/posts/create',[PostController::class,'store']);
// Route::get('image',[PostController::class,'image']);
// --------post show by slug------------

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
