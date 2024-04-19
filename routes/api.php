<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/categories', [CategoryController::class, 'viewCategories']);
Route::get('/category/{id}', [CategoryController::class, 'showCategory']);

Route::get('/posts', [PostController::class, 'viewPosts']);
Route::get('/post/{id}', [PostController::class, 'viewPost']);



Route::post('/create/comment', [CommentController::class, 'createComment']);
Route::get('/comments', [CommentController::class, 'viewComments']);


Route::middleware(['auth:sanctum', 'Admin'])->group(function () {
    Route::post('/create/category', [CategoryController::class, 'createCategory']);
    Route::put('/category/update/{id}', [CategoryController::class, 'updateCategory']);
    Route::delete('/category/destroy/{id}', [CategoryController::class, 'destroyCategory']);
    Route::post('/create/post', [PostController::class, 'createPost']);
    Route::put('/post/{id}/update', [PostController::class, 'updatePost']);
    Route::delete('/post/{id}/delete', [PostController::class, 'deletePost']);
    Route::delete('/comment/{id}/destroy', [CommentController::class, 'destroyComment']);
});
