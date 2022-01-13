<?php

use App\Http\Controllers\api\AuthController;
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
});

Route::post('logout',[AuthController::class,'logout']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
