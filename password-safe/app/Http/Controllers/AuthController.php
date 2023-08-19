<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt($request->only('email', 'password')))
        {
            return new UserResource(['message' => 'Login com sucesso!',
                'token' => $request->user()->createToken('invoice')->plainTextToken]
            );
        }

        return new UserResource(['message' => 'Falha na Autenticacao']);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return new UserResource(['token' => 'Revoked', 'status' => 200]);
    }
}
