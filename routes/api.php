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

/**
 * 用户
 */
Route::group(['prefix' => 'users', 'name' => 'user.'], function () {

    Route::get('{user}', [UserController::class, 'show'])->name('show');
    Route::post('', [UserController::class, 'index'])->name('index');

    Route::group(['middleware' => ['auth:sanctum']], function () {

        // 需要登录
        Route::put('{user}', [UserController::class, 'update'])->name('update')->middleware(['can:update,App\Models\User']);
        Route::delete('{users}', [UserController::class, 'destroy'])->name('destroy')->middleware(['can:delete,App\Models\User']);
        Route::put('{user}/edit', [UserController::class, 'edit'])->name('edit')->middleware(['can:update,App\Models\User']);

        Route::get('{user}/drafts', [UserController::class, 'drafts'])->name('articles.index')->middleware(['verified']);
    });

    Route::get('{user}/articles', [UserController::class, 'articles'])->name('articles.index');
    Route::get('{user}/posts', [UserController::class, 'posts'])->name('posts.index');
});

/**
 * 帖子
 */
Route::group(['prefix' => 'posts', 'name' => 'post.'], function () {

    Route::get('', [PostController::class, 'index'])->name('index');
    Route::get('{post}', [PostController::class, 'show'])->name('show');

    // 需要登录
    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('{post}/toggleLike', [PostController::class, 'toggleLike'])->name('toggleLike');

        // 需要认证
        Route::group(['middleware' => ['verified']], function () {

            Route::post('', [PostController::class, 'store'])->name('store')->middleware('can:create,App\Models\Post');
            Route::put('{post}', [PostController::class, 'update'])->name('upadte')->middleware('can:upate,App\Models\Post');
            Route::delete('{post}', [PostController::class, 'destroy'])->name('destory')->middleware('can:delete,App\Models\Post');

            Route::get('{post}/edit', [PostController::class, 'edit'])->name('edit')->middleware('can:upate,App\Models\Post');
        });
    });
});

/**
 * 文章
 */
Route::group(['prefix' => 'articles', 'name' => 'article.'], function () {

    Route::get('', [ArticleController::class, 'index'])->name('index');
    Route::get('{article}', [ArticleController::class, 'show'])->name('show');

    // 需要登录
    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('{article}/toggleLike', [ArticleController::class, 'toggleLike'])->name('toggleLike');

        // 需要认证
        Route::group(['middleware' => ['verified']], function () {

            Route::post('', [ArticleController::class, 'store'])->name('store')->middleware(['can:create,App\Models\Article']);
            Route::put('{id}', [ArticleController::class, 'update'])->name('update')->middleware(['can:update,App\Models\Article']);
            Route::delete('{id}', [ArticleController::class, 'destroy'])->name('destory')->middleware(['can:delete,App\Models\Article']);
            Route::get('{id}/edit', [ArticleController::class, 'edit'])->name('edit')->middleware(['can:update,App\Models\Article']);

            Route::get('{id}/publish', [ArticleController::class, 'publish'])->name('publish')->middleware(['can:create, App\Models\Article']);

            Route::get('drafts', [ArticleController::class, 'drafts'])->name('drafts.index')->middleware(['can:view-drafts']);
        });
    });

    // 文章评论
    Route::group(['prefix' => '{article}/comments', 'name' => 'comment.'], function ($article) {

        Route::get('', [CommentController::class, 'index'])->name('index');
        Route::get('{comment}', [CommentController::class, 'show'])->name('show');

        Route::group(['middleware' => ['auth:sanctum']], function () {

            Route::post('comments', [CommentController::class, 'store'])->name('store')->middleware(['can:create,App\Models\Comment']);
            Route::put('{comment}', [CommentController::class, 'update'])->name('update')->middleware(['can:update,App\Models\Comment']);
            Route::delete('{comment}', [CommentController::class, 'destroy'])->name('destory')->middleware(['can:delete,App\Models\Comment']);
        });
    });
});

/**
 * 话题
 */
Route::group(['prefix' => 'topic', 'name' => 'topic.'], function () {

    Route::get('', [TopicController::class, 'index'])->name('index');
    Route::get('{topic}', [TopicController::class, 'show'])->name('show');

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('', [TopicController::class, 'store'])->name('store')->middleware(['can:create,App\Models\Topic', 'verified']);
        Route::put('{topic}', [TopicController::class, 'update'])->name('update')->middleware(['can:update,App\Models\Topic']);
        Route::delete('{topic}', [TopicController::class, 'destroy'])->name('destory')->middleware(['can:delete,App\Models\Topic']);

        Route::get('{topic}/edit', [TopicController::class, 'edit'])->name('edit')->middleware(['can:update,App\Models\Topic']);
    });

    Route::get('{topic}/articles', [TopicController::class, 'articles'])->name('article.index');
    Route::get('{topic}/posts', [TopicController::class, 'posts'])->name('post.index');
});

Route::group(['prefix' => 'columns', 'name' => 'column.'], function () {

    Route::get('', [ColumnController::class, 'index'])->name('index');
    Route::get('{column}', [ColumnController::class, 'show'])->name('show');

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('', [ColumnController::class, 'store'])->name('store')->middleware(['can:create,App\Models\Column', 'verified']);
        Route::put('{column}', [ColumnController::class, 'update'])->name('update')->middleware(['can:update,App\Models\Column']);
        Route::delete('{column}', [ColumnController::class, 'destroy'])->name('destory')->middleware(['can:delete,App\Models\Column']);

        Route::get('{column}/edit', [ColumnController::class, 'edit'])->name('edit')->middleware(['can:update,App\Models\Column']);
    });

    Route::group(['prefix' => '{column}/comments', 'name' => 'comment.'], function ($column) {

        Route::get('', [CommentController::class, 'index'])->name('index');
        Route::get('{comment}', [CommentController::class, 'show'])->name('show');

        Route::group(['middleware' => ['auth:sanctum']], function () {

            Route::post('', [CommentController::class, 'store'])->name('store')->middleware(['can:create,App\Models\Comment']);
            Route::put('{comment}', [CommentController::class, 'update'])->name('update')->middleware(['can:update,App\Models\Comment']);
            Route::delete('{comment}', [CommentController::class, 'destroy'])->name('destory')->middleware(['can:delete,App\Models\Comment']);
        });
    });

    Route::get('{column}/articles', [ColumnController::class, 'articles'])->name('article.index');
});

Route::group(['prefix' => 'comment','name' => 'comment.'], function () {

    Route::get('{comment}/toggleLike', [CommentController::class, 'toggleLike'])->name('comment.toggleLike')->middleware('auth:sanctum');

    Route::group(['prefix' => '{commentable}/comments', 'name' => 'sub.'], function ($comment) {

        Route::get('', [CommentController::class, 'index'])->name('index');
        Route::get('{comment}', [CommentController::class, 'show'])->name('show');

        Route::group(['middleware' => ['auth:sanctum']], function () {

            Route::post('', [CommentController::class, 'store'])->name('store')->middleware(['can:create,App\Models\Comment']);
            Route::put('{comment}', [CommentController::class, 'update'])->name('update')->middleware(['can:update,App\Models\Comment']);
            Route::delete('{comment}', [CommentController::class, 'destroy'])->name('destory')->middleware(['can:delete,App\Models\Comment']);
        });
    });
});


Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name

Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::get('search', [SearchController::class, 'all'])->name('search.all');
