<?php

namespace App\Http\Controllers\Api;

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
     * 查找指定实体下的所有评论
     * @method GET
     *
     * @return Comment comment
     */
    public function index($commentable)
    {
        $comment = $commentable->comments()->paginate(20);
        return response($comment, Response::HTTP_OK);
    }

    /**
     * 查找指定评论
     * @method GET
     *
     *
     * @return Comment comment
     */
    public function show($commentable, Comment $comment)
    {
        return response($comment, Response::HTTP_OK);
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
    public function store(StoreCommentRequest $request, $commentable)
    {
        // 验证请求
        $validatedData = $request->all();

        // 创建评论
        $comment = new Comment($validatedData);

        // 保存
        $commentable->comments()->save([$comment]);

        // 当前用户
        $user = $request->user();

        // 允许用户拥有评论
        Bouncer::allow($user)->toOwn($comment)->to(['update', 'delete', 'view']);

        // 响应
        return response($comment, Response::HTTP_OK);
    }

    /**
     * 更新评论
     * @method PUT
     *
     * @return Comment comment
     */
    public function update($commentable, Comment $comment, UpdateCommentRequest $request)
    {
        // 验证请求
        $validatedData = $request->all();

        // 保存
        $comment->save($validatedData);

        // 保存
        $commentable->comments()->save([$comment]);

        // 响应
        return response($comment, Response::HTTP_OK);
    }

    /**
     * 返回评论原Markdown文本
     */
    public function edit(Comment $comment)
    {
        Gate::authorize('update', $comment);
        return response($comment->makeVisible('content_raw'), Response::HTTP_OK);
    }

    /**
     * 删除评论
     * @method DELETE
     *
     * @param uuid id
     *
     */
    public function destroy($commentable, Comment $comment)
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
     * 切换点赞状态
     */
    public function toggleLike(Comment $comment, Request $request)
    {
        $user = $request->user();

        $user->toggleLike($comment);

        return response($user->hasLiked($comment), Response::HTTP_OK);
    }
}
