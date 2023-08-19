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
            //return $this->response('Authorized', 200);
            return new UserResource(['message' => 'Chegando aqui',
                'token' => $request->user()->createToken('invoice')->plainTextToken]
            );
        }

        return new UserResource(['message' => 'Falha na autenticacao']);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return ['token' => 'Revoked', 'status' => 200];
    }
}
