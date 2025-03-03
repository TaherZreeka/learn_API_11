<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikesController;
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
    Route::get('show/comment',[CommentController::class,'getAllComment']);


Route::middleware('auth:sanctum')->group(function(){
Route::post('/logout',[AuthController::class,'logout']);
    //Blog API Development
     // 1- POST
    Route::post('add/post',[PostController::class,'add_new_post']);
    Route::post('edit/post',[PostController::class,'edit_post']);
    Route::post('edit/post/{id}',[PostController::class,'edit_post_id']);
 Route::get('single/post/{id}',[PostController::class,'getPost']);
    Route::delete('delete/post/{id}', [PostController::class, 'delete_post']);
   // 2- COMMENT
    Route::post('/comment',[CommentController::class,'postComment']);
   // 3- like
    Route::post('add/like',[LikesController::class,'add_like']);

});