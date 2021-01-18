<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;

/**
 * 用户控制器
 * @author admiral-thrawn
 */
class UserController extends Controller
{
    /**
     * 列出所有用户
     * @method GET
     * @api users
     */
    public function index()
    {
        $users = User::paginate(10);
        return response(
            [
                'data' => $users
            ],
            Response::HTTP_OK
        );
    }

    /**
     * 查找指定用户
     *
     * @method GET
     *
     * @api users/{user}
     */
    public function show(User $user)
    {
        return response(
            [
                'data' => $user
            ], Response::HTTP_OK);
    }


    /**
     * 更新用户数据
     * @method PUT
     * @api users/{user}
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->all();

        $user->save($validatedData);

        return response([
            'data' => $user
        ], Response::HTTP_OK);
    }

    /**
     * 删除用户
     * @method DELETE
     *
     * @api users/{user}
     */
    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return response([
            'message' => 'successfully deleted'
        ], Response::HTTP_OK);
    }

    /**
     * 用户发布的文章
     * @method GET
     *
     * @api users/{user}/articles
     */
    public function articles(User $user)
    {
        $articles = $user->articles()->paginate(10);
        return response([
            'data'=>$articles
        ] ,Response::HTTP_OK);
    }


    /**
     * 用户发布的帖子
     * @method GET
     *
     * @api users/{user}/posts
     */
    public function posts(User $user)
    {
        $posts = $user->posts()->paginate(10);
        return response([
            'data' => $posts
        ], Response::HTTP_OK);
    }

    public function topics()
    {
        // TODO
    }

    public function columns()
    {
        // TODO
    }

    public function comments()
    {
        // TODO
    }
}
