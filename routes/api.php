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

Route::group(['prefix' => 'posts'], function () {
    Route::get('', [PostController::class, 'index'])->name('post.index');
    Route::get('{id}', [PostController::class, 'show'])->name('post.show');
    Route::post('', [PostController::class, 'store'])->name('post.store')->middleware(['auth:sanctum', 'can:create,post']);
    Route::put('{id}', [PostController::class, 'update'])->name('post.upadte');
    Route::delete('{id}', [PostController::class, 'destroy'])->name('post.destory');
});

Route::group(['prefix' => 'articles'], function () {
    Route::get('', [ArticleController::class, 'index'])->name('article.index');
    Route::get('{id}', [ArticleController::class, 'show'])->name('article.show');
    Route::post('', [ArticleController::class, 'store'])->name('article.store');
    Route::put('{id}', [ArticleController::class, 'update'])->name('article.update');
    Route::delete('{id}', [ArticleController::class, 'destroy'])->name('article.destory');
});
