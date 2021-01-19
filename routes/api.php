<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerificationController;
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
Route::post('register', [AuthController::class, 'register'])->name('user.register');

Route::get('users/{user}', [UserController::class, 'show'])->name('user.show');
Route::post('users', [UserController::class, 'index'])->name('user.index');
Route::put('users/{user}', [UserController::class, 'update'])->name('user.update')->middleware(['auth:sanctum', 'can:update,App\Models\User']);
Route::delete('user/{users}', [UserController::class, 'destroy'])->name('user.destroy')->middleware(['auth:sanctum', 'can:delete,App\Models\User']);

Route::put('users/{user}/edit', [UserController::class, 'edit'])->name('user.edit')->middleware(['auth:sanctum', 'can:update,App\Models\User']);

Route::get('users/{user}/articles', [UserController::class, 'articles'])->name('user.articles.index');
Route::get('users/{user}/posts', [UserController::class, 'posts'])->name('user.posts.index');

Route::get('posts', [PostController::class, 'index'])->name('post.index');
Route::get('posts/{post}', [PostController::class, 'show'])->name('post.show');
Route::post('posts', [PostController::class, 'store'])->name('post.store')->middleware(['auth:sanctum', 'can:create,App\Models\Post', 'verified']);
Route::put('/posts/{post}', [PostController::class, 'update'])->name('post.upadte')->middleware('auth:sanctum', 'can:upate,App\Models\Post');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('post.destory')->middleware('auth:sanctum', 'can:delete,App\Models\Post');

Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('post.edit')->middleware('auth:sanctum', 'can:upate,App\Models\Post');

Route::post('posts/{post}/toggleLike', [PostController::class, 'toggleLike'])->name('post.toggleLike')->middleware('auth:sanctum');

Route::get('articles', [ArticleController::class, 'index'])->name('article.index');
Route::get('articles/{article}', [ArticleController::class, 'show'])->name('article.show');
Route::post('articles', [ArticleController::class, 'store'])->name('article.store')->middleware(['auth:sanctum', 'can:create,App\Models\Article']);
Route::put('articles/{id}', [ArticleController::class, 'update'])->name('article.update')->middleware(['auth:sanctum', 'can:update,App\Models\Article', 'verified']);
Route::delete('articles/{id}', [ArticleController::class, 'destroy'])->name('article.destory')->middleware(['auth:sanctum', 'can:delete,App\Models\Article']);
Route::get('articles/{id}/edit', [ArticleController::class, 'edit'])->name('article.edit')->middleware(['auth:sanctum', 'can:update,App\Models\Article', 'verified']);

Route::get('articles/{id}/publish', [ArticleController::class, 'publish'])->name('article.publish')->middleware(['auth:sanctum', 'can:create, App\Models\Article', 'verified']);

Route::get('articles/drafts', [ArticleController::class, 'drafts'])->name('articles.drafts.index')->middleware(['auth:sanctum', 'can:view-drafts', 'verified']);

Route::post('articles/{article}/toggleLike', [ArticleController::class, 'toggleLike'])->name('article.toggleLike')->middleware('auth:sanctum');

Route::get('articles/{commentable}/comments', [CommentController::class, 'index'])->name('article.comment.index');
Route::get('articles/{commentable}/comments/{comment}', [CommentController::class, 'show'])->name('article.comment.show');
Route::post('articles/{commentable}/comments', [CommentController::class, 'store'])->name('article.comment.store')->middleware(['auth:sanctum', 'can:create,App\Models\Comment']);
Route::put('articles/{commentable}/comments/{comment}', [CommentController::class, 'update'])->name('article.comment.update')->middleware(['auth:sanctum', 'can:update,App\Models\Comment']);
Route::delete('articles/{commentable}/comments/{comment}', [CommentController::class, 'destroy'])->name('article.comment.destory')->middleware(['auth:sanctum', 'can:delete,App\Models\Comment']);

Route::get('topics', [TopicController::class, 'index'])->name('topic.index');
Route::get('topics/{topic}', [TopicController::class, 'show'])->name('topic.show');
Route::post('topics', [TopicController::class, 'store'])->name('topic.store')->middleware(['auth:sanctum', 'can:create,App\Models\Topic', 'verified']);
Route::put('topics/{topic}', [TopicController::class, 'update'])->name('topic.update')->middleware(['auth:sanctum', 'can:update,App\Models\Topic']);
Route::delete('topics/{topic}', [TopicController::class, 'destroy'])->name('topic.destory')->middleware(['auth:sanctum', 'can:delete,App\Models\Topic']);

Route::get('topics/{topic}/edit', [TopicController::class, 'edit'])->name('topic.edit')->middleware(['auth:sanctum', 'can:update,App\Models\Topic']);

Route::get('topics/{topic}/articles', [TopicController::class, 'articles'])->name('topic.article.index');
Route::get('topics/{topic}/posts', [TopicController::class, 'posts'])->name('topic.post.index');

Route::get('columns/{commentable}/comments', [CommentController::class, 'index'])->name('column.comment.index');
Route::get('columns/{commentable}/comments/{comment}', [CommentController::class, 'show'])->name('column.comment.show');
Route::post('columns/{commentable}/comments', [CommentController::class, 'store'])->name('column.comment.store')->middleware(['auth:sanctum', 'can:create,App\Models\Comment']);
Route::put('columns/{commentable}/comments/{comment}', [CommentController::class, 'update'])->name('column.comment.update')->middleware(['auth:sanctum', 'can:update,App\Models\Comment']);
Route::delete('columns/{commentable}/comments/{comment}', [CommentController::class, 'destroy'])->name('column.comment.destory')->middleware(['auth:sanctum', 'can:delete,App\Models\Comment']);

Route::get('comments/{commentable}/comments', [CommentController::class, 'index'])->name('comment.sub.index');
Route::get('comments/{commentable}/comments/{comment}', [CommentController::class, 'show'])->name('comment.sub.show');
Route::post('comments/{commentable}/comments', [CommentController::class, 'store'])->name('comment.sub.store')->middleware(['auth:sanctum', 'can:create,App\Models\Comment']);
Route::put('comments/{commentable}/comments/{comments}', [CommentController::class, 'update'])->name('comment.sub.update')->middleware(['auth:sanctum', 'can:update,App\Models\Comment']);
Route::delete('comments/{commentable}/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.sub.destory')->middleware(['auth:sanctum', 'can:delete,App\Models\Comment']);

Route::get('comments/{comment}/toggleLike', [CommentController::class, 'toggleLike'])->name('comment.toggleLike')->middleware('auth:sanctum');

Route::get('columns', [ColumnController::class, 'index'])->name('column.index');
Route::get('columns/{column}', [ColumnController::class, 'show'])->name('column.show');
Route::post('columns', [ColumnController::class, 'store'])->name('column.store')->middleware(['auth:sanctum', 'can:create,App\Models\Column', 'verified']);
Route::put('columns/{column}', [ColumnController::class, 'update'])->name('column.update')->middleware(['auth:sanctum', 'can:update,App\Models\Column']);
Route::delete('columns/{column}', [ColumnController::class, 'destroy'])->name('column.destory')->middleware(['auth:sanctum', 'can:delete,App\Models\Column']);
Route::get('colums/{column}/articles', [ColumnController::class, 'articles'])->name('column.article.index');

Route::get('columns/{column}/edit', [ColumnController::class, 'edit'])->name('column.edit')->middleware(['auth:sanctum', 'can:update,App\Models\Column']);

Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name

Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::get('search', [SearchController::class, 'all'])->name('search.all');
