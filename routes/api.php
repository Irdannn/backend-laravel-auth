<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\PictureController;


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
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('/show/{user_id}', [AuthController::class, 'getUserProfile']);
});

Route::group(['middleware' => 'api', 'prefix'=> 'user'], function($router){
    Route::get('/show/{id}', [UserProfileController::class, 'show']);
    Route::get('/showuser/{user_id}', [UserProfileController::class, 'showUser']);
    Route::get('/index', [UserProfileController::class, 'index']);
    Route::put('/update/{id}', [UserProfileController::class, 'update']);
    Route::delete('/destroy/{id}', [UserProfileController::class, 'destroy']);
});

Route::group(['middleware' => 'api', 'prefix'=> 'foto'], function($router){
    Route::post('/create',[AvatarController::class,'create']);
    Route::get('/get',[AvatarController::class,'get']);
    Route::get('/show/{id}/avatar',[AvatarController::class,'show']);
    Route::patch('/edit/{id}',[AvatarController::class,'edit']);
    Route::put('/update/{id}',[AvatarController::class,'update']);
    Route::delete('/delete/{id}',[AvatarController::class,'delete']);
});

Route::group(['middleware' => 'api', 'prefix'=> 'foto1'], function($router){
    Route::post('/store',[PictureController::class,'store']);
    Route::get('/index',[PictureController::class,'index']);
    Route::get('/show/{id}/avatar',[PictureController::class,'show']);
    Route::patch('/edit/{id}',[PictureController::class,'edit']);
    Route::put('/update/{id}',[PictureController::class,'update']);
    Route::delete('/delete/{id}',[PictureController::class,'delete']);
});