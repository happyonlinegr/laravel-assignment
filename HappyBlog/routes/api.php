<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/posts',PostController::class);
Route::get('/posts/{id}/{slug}',[PostController::class,'show']);
Route::get('/users/{id}/posts',[PostController::class,'postsByUser']);

Route::post('/posts/{id}/comment',[CommentController::class,'store']);
Route::get('/users/{id}/comments',[CommentController::class,'commentsByUser']);

Route::get('/categories',[CategoryController::class,'index']);
