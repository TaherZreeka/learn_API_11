<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

    // Show All Post,No Need Authentication
    Route::get('show/post',[PostController::class,'getAllPost']);

Route::middleware('auth:sanctum')->group(function(){
Route::post('/logout',[AuthController::class,'logout']);
    //Blog API Development
    Route::post('add/post',[PostController::class,'add_new_post']);
    Route::post('edit/post',[PostController::class,'edit_post']);
    Route::post('edit/post/{id}',[PostController::class,'edit_post_id']);
    Route::delete('delete/post/{id}', [PostController::class, 'delete_post']);});
