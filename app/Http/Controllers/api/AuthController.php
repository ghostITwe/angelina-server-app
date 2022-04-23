<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


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

    public function registration(RegistrationRequest $request)
    {
        $data = $request->validated();

        $user = new User();
        $user->last_name = $data['last_name'];
        $user->first_name = $data['first_name'];
        $user->middle_name = $data['middle_name'];
        $user->email = $data['email'];
        $user->login = $data['login'];
        $user->password = Hash::make($data['password']);
        $user->role = 'user';
        $user->save();

        $user->token = $user->createToken('registration_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'token' => $user->token
        ])->setStatusCode(200);
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
