<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\BrandApiController;
use App\Http\Controllers\Api\AuthController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('products',ProductApiController::class);
Route::apiResource('categories',CategoryApiController::class);
Route::apiResource('brands',BrandApiController::class);


Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
