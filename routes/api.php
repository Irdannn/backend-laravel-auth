<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\ProfileController;

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

Route::group(['middleware' => 'api', 'prefix'=> 'auth'], function($router){
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::get('/logout', [AuthController::class, 'logout']);
    // Route::post('refresh', [AuthController::class, 'refresh']);
    // Route::get('/show/{user_id}', [AuthController::class, 'getUserProfile']);
});

Route::group(['middleware' => 'api', 'prefix'=> 'user'], function($router){
    Route::get('/show/{id}', [ProfileController::class, 'show']);
    Route::get('/showuser/{user_id}', [ProfileController::class, 'showUser']);
    Route::get('/index', [ProfileController::class, 'index']);
    Route::put('/update/{id}', [ProfileController::class, 'update']);
    Route::delete('/destroy/{id}', [ProfileController::class, 'destroy']);
});

Route::group(['middleware' => 'api', 'prefix'=> 'foto'], function($router){
    Route::post('/create',[AvatarController::class,'create']);
    Route::get('/get/{user_id}',[AvatarController::class,'get']);
    Route::get('/show/{id}/avatar',[AvatarController::class,'show']);
    Route::patch('/edit/{id}',[AvatarController::class,'edit']);
    Route::put('/update/{id}',[AvatarController::class,'update']);
    Route::delete('/delete/{id}',[AvatarController::class,'delete']);
});