<?php

namespace App\Http\Controllers;

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
        $posts = Post::pagenate(20);

        return response([
            'data' => $posts
        ], Response::HTTP_OK);
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
        return response([
            'data' => $post
        ], Response::HTTP_OK);
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
    public function store(Request $request)
    {

        // 验证请求
        $validatedData = $request->validate([
            'title' => ['required', 'min:1', 'max:100'],
            'content' => ['required', 'min:5', 'max:2000'],
            'parent_id' => ['nullable', 'string'],
            'topic_id' => ['nullable', 'string']
        ]);

        // 获取当前用户
        $user = $request->user();

        // 创建帖子
        $post = new Post($validatedData);

        // 帖子作者
        $user->posts()->save($post);

        // 授权用户拥有此贴
        Bouncer::allow($user)->toOwn($post)->to(['view', 'update', 'delete']);

        // 存储
        $post->save();

        // 返回帖子和200状态码
        return response([
            'data' => $post
        ], Response::HTTP_OK);
    }

    /**
     * 更新帖子
     * @method PUT
     * @api /posts/{post}
     *
     *
     * @return Post post
     */
    public function update(Post $post, Request $request)
    {

        // 验证请求
        $validatedData = $request->validate([
            'title' => ['required', 'min:1', 'max:100'],
            'content' => ['required', 'min:5', 'max:2000'],
            'topic_id' => ['nullable', 'string']
        ]);

        // 检查用户权限
        Gate::authorize('update', $post);

        // 保存
        $post->save($validatedData);

        // 响应
        return response([
            'data' => $post
        ], Response::HTTP_OK);
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
}
