<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Product\TourController;
use Illuminate\Support\Facades\Route;




// Auth Group
Route::group(['prefix' => 'auth'], function () {
  Route::post('/login', [AuthController::class, 'login']);
  Route::middleware('auth:sanctum')->get('/logout', [AuthController::class, 'logout']);
});


// Operator Group
Route::group(['prefix' => 'operator', 'middleware' => 'auth:sanctum'], function () {

  // create new operator
  Route::post('/create', [AuthController::class, 'createOperator']);
});


// Tour Group

Route::group(['prefix' => 'tour'], function () {
  // get all tours all users
  Route::post('/', [TourController::class, 'index']);

  // get required authentication
  Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/create', [TourController::class, 'store']);
    Route::get('/{id}', [TourController::class, 'show']);
    Route::put('/{id}', [TourController::class, 'update']);
    Route::delete('/{id}', [TourController::class, 'destroy']);
  });
});
