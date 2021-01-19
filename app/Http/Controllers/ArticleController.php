<?php

namespace App\Http\Controllers;

use App\Http\Requests\Articles\StoreArticleRequest;
use App\Http\Requests\Articles\UpdateArticleRequest;
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
     * @api /articles
     *
     * @return Article article
     */
    public function index()
    {
        $articles = Article::paginate(10);

        return response($articles, Response::HTTP_OK);
    }

    /**
     * 查找指定文章
     * @method GET
     * @api /articles/{article}
     *
     *
     * @return Article article
     */
    public function show(Article $article)
    {
        return response($article->makeVisible('content'), Response::HTTP_OK);
    }

    /**
     * 返回文章原Markdown文本
     * @api /articles/{article}/edit
     */
    public function edit(Article $article)
    {
        Gate::authorize('update', $article);
        return response($article->makeVisible('content_raw'), Response::HTTP_OK);
    }

    /**
     * 创建并存储文章
     * @method POST
     * @api /articles
     *
     * @param string title
     * @param string description
     * @param string content
     * @param uuid topic_id
     *
     * @return Article article
     */
    public function store(StoreArticleRequest $request)
    {
        // 验证请求
        $validatedData = $request->all();

        // 获取当前用户
        $user = $request->user();

        // 创建文章
        $article = new Article($validatedData);

        // 文章作者
        $user->articles()->save($article);

        // 授权用户拥有此文章
        Bouncer::allow($user)->toOwn($article)->to(['view', 'update', 'delete']);

        // 返回文章和200状态码
        return response($article, Response::HTTP_OK);
    }

    /**
     * 更新文章
     * @method PUT
     * @api /articles/{article}
     *
     *
     * @return Article article
     */
    public function update(Article $article, UpdateArticleRequest $request)
    {
        // 验证请求
        $validatedData = $request->all();

        // 保存
        $article->save($validatedData);

        // 响应
        return response($article->makeVisible('content'), Response::HTTP_OK);
    }

    /**
     * 删除文章
     * @method DELETE
     * @api /articles/{article}
     *
     */
    public function destroy(Article $article)
    {
        Gate::authorize('delete', $article);

        // 删除
        $article->delete();

        // 响应
        return response([
            'message' => 'successfully delete'
        ], Response::HTTP_OK);
    }

    /**
     * 切换点赞状态
     */
    public function toggleLike(Article $article, Request $request)
    {
        $user = $request->user();

        $user->toggleLike($article);

        return response($user->hasLiked($article), Response::HTTP_OK);
    }

    /**
     * 显示草稿
     */
    public function drafts()
    {
        $articles  = Article::withDrafts()->paginate(10);
        return response($articles, Response::HTTP_OK);
    }

    /**
     * 发布
     */
    public function publish(Article $article)
    {
        Gate::authorize('update',$article);

        return response($article, Response::HTTP_OK);
    }
}
