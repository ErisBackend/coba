<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

//route product
Route::get('/product/list',[ProductsController::class,'index']);
Route::get('/product/detail/{id}',[ProductsController::class,'show']);
Route::post('/product/edit/{id}',[ProductsController::class,'edit']);
Route::delete('/product/delete/{id}',[ProductsController::class,'delete']);
Route::post('/product/add',[ProductsController::class,'store']);
Route::get('/images/{filename}',[ProductsController::class,'image']);



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
