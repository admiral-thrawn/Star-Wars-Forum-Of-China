<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\StoreCommentRequest;
use App\Http\Requests\Comments\UpdateCommentRequest;
use App\Models\Article;
use App\Models\Column;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Silber\Bouncer\BouncerFacade as Bouncer;

/**
 * 评论控制器
 *
 * index()列表
 * show()查找指定
 * store()创建并存储
 * update()更新
 * destroy()删除
 *
 * @author admiral-thrawn
 */
class CommentController extends Controller
{
    /**
     * 查找指定文章下的所有评论
     * @method GET
     * @api /articles/{article}/comments
     *
     * @return Comment comment
     */
    public function articleIndex(Article $article)
    {
        $comment = $article->comments()->pagenate(20);
        return response([
            'data' => $comment
        ], Response::HTTP_OK);
    }

    /**
     * 查找指定评论
     * @method GET
     * @api /articles/{article}/comments/{comment}
     *
     *
     * @return Comment comment
     */
    public function articleShow(Article $article, Comment $comment)
    {
        return response([
            'data' => $comment
        ], Response::HTTP_OK);
    }


    /**
     * 创建并存储评论
     * @method POST
     * @api /articles/{article}/comments
     *
     * @param string content
     * @param uuid parent_id
     *
     * @return Comment comment
     */
    public function articleStore(StoreCommentRequest $request, Article $article)
    {
        // 验证请求
        $validatedData = $request->validate();

        // 创建评论
        $comment = new Comment($validatedData);

        // 保存
        $article->comments()->save([$comment]);

        // 当前用户
        $user = $request->user();

        // 允许用户拥有评论
        Bouncer::allow($user)->toOwn($comment)->to(['update', 'delete', 'view']);

        // 保存
        $comment->save();

        // 响应
        return response([
            'data' => $comment
        ], Response::HTTP_OK);
    }

    /**
     * 更新评论
     * @method PUT
     * @api /articles/{article}/comments/{comment}
     *
     * @return Comment comment
     */
    public function articleUpdate(Article $article, Comment $comment, UpdateCommentRequest $request)
    {
        // 验证请求
        $validatedData = $request->validate();

        // 保存
        $comment->save($validatedData);

        // 保存
        $article->comments()->save([$comment]);

        // 响应
        return response([
            'data' => $comment
        ], Response::HTTP_OK);
    }

    /**
     * 删除评论
     * @method DELETE
     * @api /articles/{article}/comments/{comment}
     *
     * @param uuid id
     *
     */
    public function articleDestroy(Article $article, Comment $comment)
    {
        // 检查用户权限
        Gate::authorize('delete', $comment);

        // 删除
        $comment->delete();

        // 响应
        return response([
            'message' => 'successfully delete'
        ], Response::HTTP_OK);
    }

    /**
     * 查找指定专栏下的所有评论
     * @method GET
     *
     * @return Comment comment
     */
    public function columnIndex(Column $column)
    {
        $comment = $column->comments()->pagenate(20);
        return response([
            'data' => $comment
        ], Response::HTTP_OK);
    }

    /**
     * 查找指定评论
     * @method GET
     *
     *
     * @return Comment comment
     */
    public function columnShow(Column $column, Comment $comment)
    {
        return response([
            'data' => $comment
        ], Response::HTTP_OK);
    }


    /**
     * 创建并存储评论
     * @method POST
     *
     * @param string content
     * @param uuid parent_id
     *
     * @return Comment comment
     */
    public function columneStore(StoreCommentRequest $request, Column $column)
    {
        // 验证请求
        $validatedData = $request->validate();

        // 创建评论
        $comment = new Comment($validatedData);

        // 保存
        $column->comments()->save([$comment]);

        // 当前用户
        $user = $request->user();

        // 允许用户拥有评论
        Bouncer::allow($user)->toOwn($comment)->to(['update', 'delete', 'view']);

        // 保存
        $comment->save();

        // 响应
        return response([
            'data' => $comment
        ], Response::HTTP_OK);
    }

    /**
     * 更新评论
     * @method PUT
     *
     * @return Comment comment
     */
    public function columnUpdate(Column $column, Comment $comment, UpdateCommentRequest $request)
    {
        // 验证请求
        $validatedData = $request->validate();

        // 保存
        $comment->save($validatedData);

        // 保存
        $column->comments()->save([$comment]);

        // 响应
        return response([
            'data' => $comment
        ], Response::HTTP_OK);
    }

    /**
     * 删除评论
     * @method DELETE
     *
     * @param uuid id
     *
     */
    public function columnDestroy(Column $column, Comment $comment)
    {
        // 检查用户权限
        Gate::authorize('delete', $comment);

        // 删除
        $comment->delete();

        // 响应
        return response([
            'message' => 'successfully delete'
        ], Response::HTTP_OK);
    }
}
