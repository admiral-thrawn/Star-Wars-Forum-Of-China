<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class VerificationController extends Controller
{
    public function verify($id, Request $request)
    {
        if(!$request->hasValidSignature())
        {
            return response()->json(["msg" => "Invalid/Expired url provided."], Response::HTTP_UNAUTHORIZED);
        }

        $user = User::findOrFail($id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response([
            'msg'=>'success'
        ], Response::HTTP_OK);
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json(["msg" => "Email already verified."], Response::HTTP_BAD_REQUEST);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(["msg" => "Email verification link sent on your email id"], Response::HTTP_OK);
    }
}
