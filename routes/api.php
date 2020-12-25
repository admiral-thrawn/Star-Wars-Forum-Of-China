<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
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

Route::post('login', [AuthController::class, 'login'])->name('user.login');

Route::get('posts', [PostController::class, 'index'])->name('post.index');
Route::get('post/{id}', [PostController::class, 'show'])->name('post.show');
Route::post('post', [PostController::class, 'store'])->name('post.store')->middleware(['auth:sanctum', 'can:create,App\Models\Post']);
Route::put('{/post/id}', [PostController::class, 'update'])->name('post.upadte')->middleware('auth:sanctum', 'can:upate,App\Models\Post');
Route::delete('/post/{id}', [PostController::class, 'destroy'])->name('post.destory')->middleware('auth:sanctum', 'can:delete,App\Models\Post');

Route::get('articles', [ArticleController::class, 'index'])->name('article.index');
Route::get('article/{id}', [ArticleController::class, 'show'])->name('article.show');
Route::post('article', [ArticleController::class, 'store'])->name('article.store')->middleware(['auth:sanctum', 'can:create,App\Models\Article']);
Route::put('article/{id}', [ArticleController::class, 'update'])->name('article.update')->middleware(['auth:sanctum', 'can:update,App\Models\Article']);
Route::delete('article/{id}', [ArticleController::class, 'destroy'])->name('article.destory')->middleware(['auth:sanctum', 'can:delete,App\Models\Article']);
