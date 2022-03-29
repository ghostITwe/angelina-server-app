<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function auth(AuthRequest $request)
    {

        $data = $request->validated();

        if  (!auth()->attempt([
            'login' => $data['login'],
            'password' => $data['password']
        ])) {
            return response()->json([
                'status' => false,
                'message' => 'Неправильно введены логин или пароль'
            ], 422);
        }

        $user = User::query()->where('login', $data['login'])->firstOrFail();

        $user->token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'token' => $user->token
        ]);
    }

    public function registration(Request $request)
    {

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'Log out'
        ]);
    }
}
