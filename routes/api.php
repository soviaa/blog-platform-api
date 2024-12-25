<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BlogController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//User
Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login',[UserController::class, 'login']);


//Blog
Route::get('/blog',[BlogCOntroller::class, 'viewBlog'])->middleware('auth:sanctum');
// Route::get('/blog',[BlogCOntroller::class, 'viewBlog']);
Route::get('/blog/{id}', [BlogController::class, 'viewSingleBlog'])->middleware('auth:sanctum');
Route::post('/blog/add', [BlogController::class, 'addBlog'])->middleware('auth:sanctum');
Route::patch('/blog/update/{id}',[BlogController::class,'updateBlog'])->middleware('auth:sanctum');
Route::delete('/blog/delete/{id}',[BlogController::class,'deleteBlog'])->middleware('auth:sanctum');
