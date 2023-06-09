<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get("books",[\App\Http\Controllers\BookController::class,'index']);
Route::post("books",[\App\Http\Controllers\BookController::class,'store']);
Route::post("update/books/{id}",[\App\Http\Controllers\BookController::class,'update']);
Route::post("destroy/books/{id}",[\App\Http\Controllers\BookController::class,'destroy']);

