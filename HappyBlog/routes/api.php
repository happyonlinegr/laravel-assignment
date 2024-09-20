<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts',[PostController::class,'index']);
Route::middleware(['auth:sanctum'])->post('/posts',[PostController::class,'store']);
Route::get('/posts/{id}/{slug}',[PostController::class,'show']);
Route::middleware(['auth:sanctum'])->put('/posts/{id}',[PostController::class,'update']);
Route::middleware(['auth:sanctum'])->delete('/posts/{id}',[PostController::class,'destroy']);
Route::middleware(['auth:sanctum'])->get('/users/{id}/posts',[PostController::class,'postsByUser']);

Route::middleware(['auth:sanctum'])->post('/posts/{id}/comment',[CommentController::class,'store']);
Route::get('/users/{id}/comments',[CommentController::class,'commentsByUser']);

Route::get('/categories',[CategoryController::class,'index']);