<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        if (Auth::attempt($credentials)) {

            $user = User::where('email',$request->get('email'))->first();

            $token = $user->createToken($request->get('email'))->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response($response, Response::HTTP_OK);
        } else {
            return response([
                'Bad credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }
    }
}
