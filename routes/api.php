<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\FotoProfileController;


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
});

Route::group(['middleware' => 'api', 'prefix'=> 'user'], function($router){
    Route::get('/show/{id}', [UserProfileController::class, 'show']);
    Route::get('/index', [UserProfileController::class, 'index']);
    Route::put('/update/{id}', [UserProfileController::class, 'update']);
    Route::delete('/destroy/{id}', [UserProfileController::class, 'destroy']);
});

Route::group(['middleware' => 'api', 'prefix'=> 'foto'], function($router){
    Route::post('/store', [FotoProfileController::class, 'store']);
    Route::get('/show/{id}/image_path', [FotoProfileController::class, 'show']);
    Route::get('/index', [FotoProfileController::class, 'index']);
    Route::put('/update/{id}', [FotoProfileController::class, 'update']);
    Route::delete('/destroy/{id}', [FotoProfileController::class, 'destroy']);
});

