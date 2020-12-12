<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * 与帖子有关的API
 * @api /api/post/*
 */
Route::group(['prefix' => 'post'], function () {

    /**
     * 创建帖子
     * @api POST /api/post/
     * @param JSON
     * @return JSON Post
     */
    Route::post('/', 'PostController@create');

    /**
     * 根据id查找指定帖子
     * @api GET /api/post/{id}
     * @param string id
     * @return JSON Post
     */
    Route::get('/{id}', 'PostController@find');

    /**
     * 列出帖子
     * @api GET /api/post
     * @param int page
     * @return List Posts
     */
    Route::get('', 'PostController@index');

    /**
     * 根据id删除指定帖子
     * @api DELETE /api/post/{id}
     * @param string id
     * @return JSON res
     */
    Route::delete('/{id}', 'PostController@delete');

    /**
     * post下的comments
     * @api /api/post/{id}/comment/
     */
    Route::group(['prefix' => '{pid}/comment/'], function () {

        /**
         * 根据帖子id和评论id查找评论
         * @api /api/post/{id}/comment/{id}
         * @param string pid
         * @param string id
         *
         * @return JSON comment
         */
        Route::get('/{id}', 'CommentController@find');
    });
});

Route::group(['prefix' => 'article'], function () {
});

Route::group(['prefix' => 'tags'], function () {
});

Route::group(['prefix' => 'topic'], function () {
});
