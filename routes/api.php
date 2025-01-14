<?php

use App\Http\Controllers\AccommodationController;
use App\Http\Controllers\RoomTypeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;

// Rutas API para Hoteles
Route::group(['prefix'=> 'hotels'], function () {
    Route::get('/', [HotelController::class, 'index']);
    Route::post('/create', [HotelController::class, 'store']);
    Route::get('/{id}', [HotelController::class, 'show']);
    Route::put('/{id}', [HotelController::class, 'update']);
    Route::delete('/{id}', [HotelController::class, 'destroy']);
});

// Rutas API para Habitaciones
Route::group(['prefix'=> 'rooms'], function () {
    Route::get('/', [RoomController::class, 'index']);
    Route::get('/{id}/hotel', [RoomController::class, 'roomsByHotel']);
    Route::post('/create', [RoomController::class, 'store']);
    Route::get('/{id}', [RoomController::class, 'show']);
    Route::put('/{id}', [RoomController::class, 'update']);
    Route::delete('/{id}', [RoomController::class, 'destroy']);
});

Route::group(['prefix'=> 'catalog'], function () {
    Route::get('/room-types', [RoomTypeController::class,'index']);
    Route::get('/accommodations', [AccommodationController::class,'index']);
});
