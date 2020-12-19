<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    public function index()
    {
    }

    /**
     * 查找指定帖子
     * @method GET
     * @api /posts/{id}
     *
     */
    public function show($id)
    {
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

        // 如果有父级帖子
        if (!$validatedData['parent_id'] == null) {
            $parent = Post::find($validatedData['parent_id']);
            $parent->subPosts()->save($post);
        }

        // 如果有话题
        if (!$validatedData['topic_id'] == null) {
            $topic = Topic::find($validatedData['topic_id']);
            $topic->posts()->save($post);
        }

        // 授权用户修改此贴
        Bouncer::allow($user)->toOwn(Post::class);

        // 存储
        $post->save();

        // 返回帖子和200状态码
        return response([
            'data' => $post
        ], Response::HTTP_OK);
    }

    public function update($id)
    {
    }

    public function destory($id)
    {
    }
}
