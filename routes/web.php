<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->middleware('auth:sanctum');
Route::POST('/join-event', [App\Http\Controllers\EventController::class, 'joinEvent'])->middleware('auth:sanctum');
Route::POST('/leave-event', [App\Http\Controllers\EventController::class, 'leaveEvent'])->middleware('auth:sanctum');
Route::get('/events', [App\Http\Controllers\EventController::class, 'updateEvents'])->middleware('auth:sanctum');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
