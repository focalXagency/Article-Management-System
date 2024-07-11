<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlockController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ArticlesController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\BeAuthorRequestsController;
use App\Http\Controllers\Api\AddAuthorsToArticleController;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::resource('/requests', BeAuthorRequestsController::class);
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/category/{id}', [CategoryController::class, 'show']);
    Route::resource('/articles', ArticlesController::class);
});

Route::resource('/comment', CommentController::class);
Route::resource('/block', BlockController::class);
Route::post('/favourite',[FavoriteController::class,'favorite'])->name('favorite');
Route::post('/addauthor', [AddAuthorsToArticleController::class,'add_authors']);
