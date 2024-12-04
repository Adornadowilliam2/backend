<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\UserController;

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::middleware('auth:api')->get('/checkToken',[AuthController::class,'checktoken']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
Route::middleware("auth:api")->post("/search", [AuthController::class, 'search']);
Route::middleware("auth:api")->get("/users", [UserController::class, 'index']);

Route::prefix('/rooms')->middleware(['auth:api'])->group(function(){
    Route::get('/',[RoomController::class,'index']);
    Route::get('/{room}',[RoomController::class,'show']);
    Route::post('/',[RoomController::class,'create']);
    Route::patch('/{room}',[RoomController::class,'update']);
    Route::delete('/{room}',[RoomController::class,'destroy']);
});

Route::prefix('/bookings')->middleware(['auth:api'])->group(function(){        
    Route::get('/',[BookingController::class,'index']);
    Route::get('/{booking}',[BookingController::class,'show']);
    Route::post('/',[BookingController::class,'store']);
    Route::post('/{booking}',[BookingController::class,'update']);
    Route::delete('/{booking}',[BookingController::class,'destroy']);
});


Route::prefix('/room-types')->middleware(['auth:api'])->group(function(){
    Route::get('/',[RoomTypeController::class,'index']);
    Route::post('/',[RoomTypeController::class,'create']);
    Route::post('/{room-type}',[RoomTypeController::class,'update']);
    Route::delete('/{room-type}',[RoomTypeController::class,'destroy']);
});