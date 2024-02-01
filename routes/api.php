<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Auth;
use App\Http\Controllers\Api\Ref\Api;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Ref\JenisApi;
use App\Http\Controllers\Api\Ref\PerangkatDaerah;
use App\Http\Controllers\Api\User\UserController;

// User
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::post('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// JenisApi
Route::get('/jenis-api', [JenisApi::class, 'index']);
Route::post('/jenis-api', [JenisApi::class, 'store']);
Route::post('/jenis-api/{id}', [JenisApi::class, 'update']);
Route::delete('/jenis-api/{id}', [JenisApi::class, 'destroy']);

// Perangkat Daerah
Route::get('/perangkat-daerah', [PerangkatDaerah::class, 'index']);
Route::post('/perangkat-daerah', [PerangkatDaerah::class, 'store']);
Route::post('/perangkat-daerah/{id}', [PerangkatDaerah::class, 'update']);
Route::delete('/perangkat-daerah/{id}', [PerangkatDaerah::class, 'destroy']);

// Daftar API
Route::get('/daftar-api', [Api::class, 'index']);
Route::post('/daftar-api', [Api::class, 'store']);
Route::post('/daftar-api/{id}', [Api::class, 'update']);
Route::delete('/daftar-api/{id}', [Api::class, 'destroy']);







// Route::post('/login', [Auth::class, 'login']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/logout', [Auth::class, 'logout']);

//     Route::get('/users', [UserController::class, 'index']);
//     Route::get('/users/{id}', [UserController::class, 'show']);
//     Route::post('/users', [UserController::class, 'store']);
//     Route::post('/users/{id}', [UserController::class, 'update']);
//     Route::delete('/users/{id}', [UserController::class, 'destroy']);
// });
