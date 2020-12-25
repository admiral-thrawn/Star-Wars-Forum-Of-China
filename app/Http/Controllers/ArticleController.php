<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Silber\Bouncer\BouncerFacade as Bouncer;

/**
 * 文章控制器
 *
 * index()列表
 * show()查找指定
 * store()创建并存储
 * update()更新
 * destroy()删除
 *
 * @author admiral-thrawn
 */
class ArticleController extends Controller
{

    /**
     * 返回所有文章
     *
     * @method GET
     * @api /article
     *
     * @return Article article
     */
    public function index()
    {
        $articles = Article::pagenate(20);

        return response([
            'data' => $articles
        ], Response::HTTP_OK);
    }

    /**
     * 查找指定文章
     * @method GET
     * @api /articles/{id}
     *
     * @param uuid id
     *
     * @return Article article
     */
    public function show($id)
    {
        $article = Article::findOrFail($id)->with('author');

        return response([
            'data' => $article
        ], Response::HTTP_OK);
    }

    /**
     * 创建并存储文章
     * @method POST
     * @api /article
     *
     * @param string title
     * @param string description
     * @param string content
     * @param uuid topic_id
     *
     * @return Article article
     */
    public function store(Request $request)
    {
        // 验证请求
        $validatedData = $request->validate([
            'title' => ['required', 'min:1', 'max:45'],
            'description' => ['required', 'min:1', 'max:250'],
            'content' => ['required', 'min:5', 'max:8000'],
            'topic_id' => ['nullable', 'string']
        ]);

        // 获取当前用户
        $user = $request->user();

        // 创建文章
        $article = new Article($validatedData);

        // 文章作者
        $user->articles()->save($article);

        // 授权用户拥有此文章
        Bouncer::allow($user)->toOwn($article)->to(['view', 'update', 'delete']);

        // 存储
        $article->save();

        // 返回文章和200状态码
        return response([
            'data' => $article
        ], Response::HTTP_OK);
    }

    /**
     * 更新文章
     * @method PUT
     * @api /article/{id}
     *
     * @param uuid id
     *
     * @return Article article
     */
    public function update($id, Request $request)
    {
        // 验证请求
        $validatedData = $request->validate([
            'title' => ['required', 'min:1', 'max:45'],
            'description' => ['required', 'min:1', 'max:250'],
            'content' => ['required', 'min:5', 'max:8000'],
            'topic_id' => ['nullable', 'string']
        ]);

        // 查找文章
        $article = Article::findOrFail($id);

        // 检查用户权限
        Gate::authorize('delete', $article);

        // 保存
        $article->save($validatedData);

        // 响应
        return response([
            'data' => $article
        ], Response::HTTP_OK);
    }

    /**
     * 删除文章
     * @method DELETE
     * @api /article/{id}
     *
     * @param uuid id
     *
     */
    public function destroy($id)
    {
        // 查找文章
        $article = Article::findOrFail($id);

        // 检查用户权限
        Gate::authorize('delete', $article);

        // 删除
        $article->delete();

        // 响应
        return response([
            'message' => 'successfully delete'
        ], Response::HTTP_OK);
    }
}
