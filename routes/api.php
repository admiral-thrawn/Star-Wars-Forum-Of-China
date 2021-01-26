<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Api\ColumnController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Api\TopicController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Auth\VerificationController;
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

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

/**
 * 用户
 */
Route::group(['prefix' => 'users'], function () {

    Route::get('{user}', [UserController::class, 'show']);
    Route::post('', [UserController::class, 'index']);

    Route::group(['middleware' => ['auth:sanctum']], function () {

        // 需要登录
        Route::put('{user}', [UserController::class, 'update'])->middleware(['can:update,App\Models\User']);
        Route::delete('{users}', [UserController::class, 'destroy'])->middleware(['can:delete,App\Models\User']);
        Route::put('{user}/edit', [UserController::class, 'edit'])->middleware(['can:update,App\Models\User']);

        Route::get('{user}/drafts', [UserController::class, 'drafts'])->middleware(['verified']);
    });

    Route::get('{user}/articles', [UserController::class, 'articles']);
    Route::get('{user}/posts', [UserController::class, 'posts']);
});

/**
 * 帖子
 */
Route::group(['prefix' => 'posts'], function () {

    Route::get('', [PostController::class, 'index']);
    Route::get('{post}', [PostController::class, 'show']);

    // 需要登录
    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('{post}/toggleLike', [PostController::class, 'toggleLike']);

        // 需要认证
        Route::group(['middleware' => ['verified']], function () {

            Route::post('', [PostController::class, 'store'])->middleware('can:create,App\Models\Post');
            Route::put('{post}', [PostController::class, 'update'])->middleware('can:update,App\Models\Post');
            Route::delete('{post}', [PostController::class, 'destroy'])->middleware('can:delete,App\Models\Post');

            Route::get('{post}/edit', [PostController::class, 'edit'])->middleware('can:update,App\Models\Post');
        });
    });
});

/**
 * 文章
 */
Route::apiResource('articles', ArticleController::class);
Route::get('drafts', [ArticleController::class, 'drafts']);
Route::group(['prefix' => 'articles'], function () {

    Route::get('{article}/toggleLike', [ArticleController::class, 'toggleLike']);

    // 文章评论
    Route::group(['prefix' => '{article}/comments'], function () {

        Route::get('', [CommentController::class, 'index']);
        Route::get('{comment}', [CommentController::class, 'show']);

        Route::group(['middleware' => ['auth:sanctum']], function () {

            Route::post('comments', [CommentController::class, 'store'])->middleware(['can:create,App\Models\Comment']);
            Route::put('{comment}', [CommentController::class, 'update'])->middleware(['can:update,App\Models\Comment']);
            Route::delete('{comment}', [CommentController::class, 'destroy'])->middleware(['can:delete,App\Models\Comment']);
        });
    });
});

/**
 * 话题
 */
Route::group(['prefix' => 'topic'], function () {

    Route::get('', [TopicController::class, 'index']);
    Route::get('{topic}', [TopicController::class, 'show']);

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('', [TopicController::class, 'store'])->middleware(['can:create,App\Models\Topic', 'verified']);
        Route::put('{topic}', [TopicController::class, 'update'])->middleware(['can:update,App\Models\Topic']);
        Route::delete('{topic}', [TopicController::class, 'destroy'])->middleware(['can:delete,App\Models\Topic']);

        Route::get('{topic}/edit', [TopicController::class, 'edit'])->middleware(['can:update,App\Models\Topic']);
    });

    Route::get('{topic}/articles', [TopicController::class, 'articles']);
    Route::get('{topic}/posts', [TopicController::class, 'posts']);
});

Route::group(['prefix' => 'columns'], function () {

    Route::get('', [ColumnController::class, 'index']);
    Route::get('{column}', [ColumnController::class, 'show']);

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('', [ColumnController::class, 'store'])->middleware(['can:create,App\Models\Column', 'verified']);
        Route::put('{column}', [ColumnController::class, 'update'])->middleware(['can:update,App\Models\Column']);
        Route::delete('{column}', [ColumnController::class, 'destroy'])->middleware(['can:delete,App\Models\Column']);

        Route::get('{column}/edit', [ColumnController::class, 'edit'])->middleware(['can:update,App\Models\Column']);
    });

    Route::group(['prefix' => '{column}/comments'], function () {

        Route::get('', [CommentController::class, 'index']);
        Route::get('{comment}', [CommentController::class, 'show']);

        Route::group(['middleware' => ['auth:sanctum']], function () {

            Route::post('', [CommentController::class, 'store'])->middleware(['can:create,App\Models\Comment']);
            Route::put('{comment}', [CommentController::class, 'update'])->middleware(['can:update,App\Models\Comment']);
            Route::delete('{comment}', [CommentController::class, 'destroy'])->middleware(['can:delete,App\Models\Comment']);
        });
    });

    Route::get('{column}/articles', [ColumnController::class, 'articles']);
});

Route::group(['prefix' => 'comment'], function () {

    Route::get('{comment}/toggleLike', [CommentController::class, 'toggleLike'])->middleware('auth:sanctum');

    Route::group(['prefix' => '{commentable}/comments', 'name' => 'sub.'], function () {

        Route::get('', [CommentController::class, 'index']);
        Route::get('{comment}', [CommentController::class, 'show']);

        Route::group(['middleware' => ['auth:sanctum']], function () {

            Route::post('', [CommentController::class, 'store'])->middleware(['can:create,App\Models\Comment']);
            Route::put('{comment}', [CommentController::class, 'update'])->middleware(['can:update,App\Models\Comment']);
            Route::delete('{comment}', [CommentController::class, 'destroy'])->middleware(['can:delete,App\Models\Comment']);
        });
    });
});


Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name

Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::get('search', [SearchController::class, 'all'])->name('search.all');
