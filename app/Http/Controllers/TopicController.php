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
        $topic = Topic::pagenate(20);

        return response([
            'data' => $topic
        ], Response::HTTP_OK);
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
        return response([
            'data' => $topic
        ], Response::HTTP_OK);
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
        $validatedData = $request->validate();

        // 当前用户
        $user = $request->user();

        // 创建话题
        $topic = new Topic($validatedData);

        // 存储
        $user->topics()->save($topic);

        // 授权用户拥有此话题
        Bouncer::allow($user)->toOwn($topic)->to(['view', 'update', 'delete']);

        // 返回话题和200状态码
        return response([
            'data' => $topic
        ], Response::HTTP_OK);
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
        $validatedData = $request->validate();

        // 保存
        $topic->save($validatedData);

        // 返回话题和200状态码
        return response([
            'data' => $topic
        ], Response::HTTP_OK);
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
}
