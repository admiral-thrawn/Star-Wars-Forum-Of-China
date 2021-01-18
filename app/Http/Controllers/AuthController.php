<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUserRequest;
use App\Models\Article;
use App\Models\Column;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Silber\Bouncer\BouncerFacade as Bouncer;

/**
 * 用户认证、授权控制器
 * @author admiral-thrawn
 */
class AuthController extends Controller
{

    /**
     * 用户登录
     *
     * @method POST
     * @api /login
     *
     * @param string email
     * @param string password
     *
     * @return User user
     * @return string token
     */
    public function login(Request $request)
    {
        // 验证提交的请求
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string']
        ]);

        // 用户登录凭证
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        // 用户认证
        if (Auth::attempt($credentials)) {

            // 根据邮箱查找用户
            $user = User::where('email', $request->get('email'))->first();

            // 创建令牌
            $token = $user->createToken($request->get('email'))->plainTextToken;

            // 返回用户信息和令牌
            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response($response, Response::HTTP_OK);
        } else {

            // 如果认证失败，返回401状态码和消息提示
            return response([
                'message' => 'Bad credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    public function register(StoreUserRequest $request)
    {
        $validatedData = $request->all();

        $user = new User($validatedData);

        $user->password = bcrypt($validatedData['password']);

        $user->save();

        Bouncer::allow($user)->to(['create', 'update', 'delete', 'view'], [Post::class, Article::class, Comment::class, Column::class, Topic::class]);
        Bouncer::allow($user)->to(['update', 'delete', 'view'], User::class);
        Bouncer::allow($user)->toOwn($user)->to(['update', 'delete', 'view']);

        $user->sendEmailVerificationNotification();

        // 创建令牌
        $token = $user->createToken($request->get('email'))->plainTextToken;

        return response([
            'data' => $user,
            'token' => $token
        ], Response::HTTP_OK);
    }
}
