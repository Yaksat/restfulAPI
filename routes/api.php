<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login',[UserController::class,'loginUser']);
Route::post('register',[UserController::class,'registerUser']);


Route::group(['middleware' => 'auth:sanctum'],function(){
    Route::get('user',[UserController::class,'userDetails']);
    Route::get('logout',[UserController::class,'logout']);
    Route::post('create_event',[EventController::class,'create']);
    Route::get('events',[EventController::class,'getEvents']);
    Route::get('participate/{event}',[EventController::class,'participate']);
    Route::get('remove_participant/{event}',[EventController::class,'removeParticipant']);
    Route::delete('/events/{event}',[EventController::class,'delete']);
});
