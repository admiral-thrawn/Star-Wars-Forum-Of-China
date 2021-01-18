<?php

namespace App\Http\Controllers;

use App\Http\Requests\Topics\StoreTopicRequest;
use App\Http\Requests\Topics\UpdateTopicRequest;
use App\Models\Topic;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Silber\Bouncer\BouncerFacade as Bouncer;

/**
 * 话题控制器
 *
 * index()列表
 * show()查找指定
 * store()创建并存储
 * update()更新
 * destroy()删除
 *
 * @author admiral-thrawn
 */
class TopicController extends Controller
{
    /**
     * 返回所有话题
     *
     * @method GET
     * @api /topics
     *
     * @return Topic topic
     */
    public function index()
    {
        $topic = Topic::paginate(20);

        return response($topic, Response::HTTP_OK);
    }

    /**
     * 查找指定话题
     * @method GET
     * @api /topics/{topic}
     *
     *
     * @return Topic topic
     */
    public function show(Topic $topic)
    {
        return response($topic, Response::HTTP_OK);
    }

    /**
     * 创建并存储话题
     * @method POST
     * @api /topics
     *
     * @param string name
     * @param string description
     *
     * @return Topic topic
     */
    public function store(StoreTopicRequest $request)
    {
        // 请求验证
        $validatedData = $request->all();

        // 当前用户
        $user = $request->user();

        // 创建话题
        $topic = new Topic($validatedData);

        // 存储
        $user->topics()->save($topic);

        // 授权用户拥有此话题
        Bouncer::allow($user)->toOwn($topic)->to(['view', 'update', 'delete']);

        // 返回话题和200状态码
        return response($topic, Response::HTTP_OK);
    }

    /**
     * 更新话题
     * @method PUT
     * @api /topics/{topic}
     *
     *
     * @return Topic topic
     */
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        // 请求验证
        $validatedData = $request->all();

        // 保存
        $topic->save($validatedData);

        // 返回话题和200状态码
        return response($topic, Response::HTTP_OK);
    }

    /**
     * 返回话题原Markdown文本
     * @api /topics/{topic}
     */
    public function edit(Topic $topic)
    {
        return response($topic->makeVisible('description_raw'), Response::HTTP_OK);
    }

    /**
     * 删除话题
     * @method DELETE
     * @api /topics/{topic}
     *
     * @param uuid id
     *
     */
    public function destroy(Topic $topic)
    {
        Gate::authorize('delete', $topic);

        $topic->delete();

        // 响应
        return response([
            'message' => 'successfully delete'
        ], Response::HTTP_OK);
    }

    /**
     * 查找话题下的文章
     * @method GET
     *
     * @param Topic topic
     */
    public function articles(Topic $topic)
    {
        $articles = $topic->articles()->paginate(10);

        return response($articles, Response::HTTP_OK);
    }

    /**
     * 查找话题下的帖子
     * @method GEt
     *
     * @param Topic topic
     */
    public function posts(Topic $topic)
    {
        $posts = $topic->posts()->paginate(10);

        return response($posts, Response::HTTP_OK);
    }
}
