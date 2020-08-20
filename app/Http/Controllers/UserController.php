<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create user
     *
     * @param UserRegisterRequest $request
     *
     * @return JsonResponse [string] message
     */
    public function register(UserRegisterRequest $request): JsonResponse
    {
        $user = new User(
            ['name' => $request->name, 'email' => $request->email, 'password' => bcrypt($request->password)]
        );
        $user->save();

        return response()->json(['success' => true, 'payload' => 'User registered'], 201);
    }

    /**
     * Login user and create token
     *
     * @param UserLoginRequest $request
     *
     * @return JsonResponse [string] access_token
     */
    public function login(UserLoginRequest $request): JsonResponse
    {
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 401);
        }
        $user = $request->user();
        $tokenResult = $user->createToken('Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();

        return response()->json(
            [
                'success' => true,
                'payload' => [
                    'access_token' => $tokenResult->accessToken,
                    'token_type' => 'Bearer',
                    'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
                ],
            ]
        );
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     *
     * @return JsonResponse [string] message
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return response()->json(['success' => true, 'payload' => 'Successfully logged out',]);
    }

    /**
     * Get the authenticated User
     *
     * @param Request $request
     *
     * @return JsonResponse [json] user object
     */
    public function user(Request $request): JsonResponse
    {
        return response()->json(['success' => true, 'payload' => $request->user()]);
    }
}
