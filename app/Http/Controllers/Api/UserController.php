<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
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
            $users,
            Response::HTTP_OK
        );
    }

    /**
     * 查找指定用户
     *
     * @method GET
     *
     * @param User $user
     * @return Application|ResponseFactory|Response
     * @api users/{user}
     */
    public function show(User $user)
    {
        return response(
            $user,
            Response::HTTP_OK
        );
    }


    /**
     * 更新用户数据
     * @method PUT
     * @param UpdateUserRequest $request
     * @param User $user
     * @return Application|ResponseFactory|Response
     * @api users/{user}
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->all();

        $user->save($validatedData);

        return response($user, Response::HTTP_OK);
    }

    /**
     * @param User $user
     * @return Application|ResponseFactory|Response
     * @throws AuthorizationException
     */
    public function edit(User $user)
    {

        Gate::authorize('update', $user);

        return response($user->makeVisible('description_raw'), Response::HTTP_OK);
    }

    /**
     * 删除用户
     * @method DELETE
     *
     * @param User $user
     * @return Application|ResponseFactory|Response
     * @throws AuthorizationException
     * @throws Exception
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
     * @param User $user
     * @return Application|ResponseFactory|Response
     * @api users/{user}/articles
     */
    public function articles(User $user)
    {
        $articles = $user->articles()->paginate(10);
        return response($articles, Response::HTTP_OK);
    }

    /**
     * 用户文章草稿
     * @method GET
     *
     * @param User $user
     * @return Application|ResponseFactory|Response
     * @throws AuthorizationException
     * @api users/{user}/drafts
     */
    public function drafts(User $user)
    {
        Gate::authorize('update',$user);
        $articles = $user->articles()->onlyDrafts()->paginate(10);
        return response($articles, Response::HTTP_OK);
    }


    /**
     * 用户发布的帖子
     * @method GET
     *
     * @param User $user
     * @return Application|ResponseFactory|Response
     * @api users/{user}/posts
     */
    public function posts(User $user)
    {
        $posts = $user->posts()->paginate(10);
        return response($posts, Response::HTTP_OK);
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
