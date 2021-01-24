<?php

namespace App\Http\Controllers;

use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Silber\Bouncer\BouncerFacade as Bouncer;

/**
 * 帖子控制器
 *
 * index()列表
 * show()查找指定
 * store()创建并存储
 * update()更新
 * destroy()删除
 *
 * @author admiral-thrawn
 */
class PostController extends Controller
{
    /**
     * 返回所有帖子
     *
     * @method GET
     * @api /posts
     *
     * @return Post post
     */
    public function index()
    {
        $posts = Post::paginate(20);

        return response($posts, Response::HTTP_OK);
    }

    /**
     * 查找指定帖子
     * @method GET
     * @api /posts/{post}
     *
     *
     * @return Post post
     */
    public function show(Post $post)
    {
        return response($post, Response::HTTP_OK);
    }

    /**
     * 创建并存储帖子
     * @method POST
     * @api /posts
     *
     * @param string title
     * @param string content
     * @param uuid parent_id
     * @param uuid topic_id
     *
     * @return Post post
     */
    public function store(StorePostRequest $request)
    {

        // 验证请求
        $validatedData = $request->all();

        // 获取当前用户
        $user = $request->user();

        // 创建帖子
        $post = new Post($validatedData);

        // 帖子作者
        $user->posts()->save($post);

        // 授权用户拥有此贴
        Bouncer::allow($user)->toOwn($post)->to(['view', 'update', 'delete']);

        // 返回帖子和200状态码
        return response($post, Response::HTTP_OK);
    }

    /**
     * 更新帖子
     * @method PUT
     * @api /posts/{post}
     *
     *
     * @return Post post
     */
    public function update(Post $post, UpdatePostRequest $request)
    {

        // 验证请求
        $validatedData = $request->all();

        // 保存
        $post->save($validatedData);

        // 响应
        return response($post, Response::HTTP_OK);
    }

    /**
     * 返回帖子原Markdown文本
     * @api /posts/{post}/edit
     */
    public function edit(Post $post)
    {
        Gate::authorize('update', $post);
        return response($post->makeVisible('content_raw'), Response::HTTP_OK);
    }

    /**
     * 删除帖子
     * @method DELETE
     * @api /posts/{post}
     *
     * @param uuid id
     *
     */
    public function destroy(Post $post)
    {
        // 检查用户权限
        Gate::authorize('delete', $post);

        // 删除
        $post->delete();

        // 响应
        return response([
            'message' => 'successfully delete'
        ], Response::HTTP_OK);
    }

    /**
     * 切换点赞状态
     */
    public function toggleLike(Post $post, Request $request)
    {
        $user = $request->user();

        $user->toggleLike($post);

        return response($user->hasLiked($post),Response::HTTP_OK);
    }
}
