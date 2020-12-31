<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TopicController;
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
Route::get('posts/{post}', [PostController::class, 'show'])->name('post.show');
Route::post('posts', [PostController::class, 'store'])->name('post.store')->middleware(['auth:sanctum', 'can:create,App\Models\Post']);
Route::put('/posts/{post}', [PostController::class, 'update'])->name('post.upadte')->middleware('auth:sanctum', 'can:upate,App\Models\Post');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destory')->middleware('auth:sanctum', 'can:delete,App\Models\Post');

Route::get('articles', [ArticleController::class, 'index'])->name('article.index');
Route::get('articles/{article}', [ArticleController::class, 'show'])->name('article.show');
Route::post('articles', [ArticleController::class, 'store'])->name('article.store')->middleware(['auth:sanctum', 'can:create,App\Models\Article']);
Route::put('articles/{article}', [ArticleController::class, 'update'])->name('article.update')->middleware(['auth:sanctum', 'can:update,App\Models\Article']);
Route::delete('articles/{article}', [ArticleController::class, 'destroy'])->name('article.destory')->middleware(['auth:sanctum', 'can:delete,App\Models\Article']);

Route::get('articles/{article}/comments', [CommentController::class, 'index'])->name('article.comment.index');
Route::get('articles/{article}/comments/{comment}', [CommentController::class, 'show'])->name('article.comment.show');
Route::post('articles/{article}/comments', [CommentController::class, 'store'])->name('article.comment.store')->middleware(['auth:sanctum', 'can:create,App\Models\Comment']);
Route::put('articles/{article}/comments/{comment}', [CommentController::class, 'update'])->name('article.comment.update')->middleware(['auth:sanctum', 'can:update,App\Models\Comment']);
Route::delete('articles/{article}/comments/{comment}', [CommentController::class, 'destroy'])->name('article.comment.destory')->middleware(['auth:sanctum', 'can:delete,App\Models\Comment']);

Route::get('topics', [TopicController::class, 'index'])->name('topic.index');
Route::get('topics/{topic}', [TopicController::class, 'show'])->name('topic.show');
Route::post('topics', [TopicController::class, 'store'])->name('topic.store')->middleware(['auth:sanctum', 'can:create,App\Models\Topic']);
Route::put('topics/{topic}', [TopicController::class, 'update'])->name('topic.update')->middleware(['auth:sanctum', 'can:update,App\Models\Topic']);
Route::delete('topics/{topic}', [TopicController::class, 'destroy'])->name('topic.destory')->middleware(['auth:sanctum', 'can:delete,App\Models\Topic']);

Route::get('articles/{article}/comments', [CommentController::class, 'articleIndex'])->name('article.comment.index');
Route::get('articles/{article}/comments/{comment}', [CommentController::class, 'articleShow'])->name('article.comment.show');
Route::post('articles/{article}/comments', [CommentController::class, 'articleStore'])->name('article.comment.store')->middleware(['auth:sanctum', 'can:create,App\Models\Comment']);
Route::put('articles/{article}/comments/{comment}', [CommentController::class, 'articleUpdate'])->name('article.comment.update')->middleware(['auth:sanctum', 'can:update,App\Models\Comment']);
Route::delete('articles/{article}/comments/{comment}', [CommentController::class, 'articleDestroy'])->name('article.comment.destory')->middleware(['auth:sanctum', 'can:delete,App\Models\Comment']);
