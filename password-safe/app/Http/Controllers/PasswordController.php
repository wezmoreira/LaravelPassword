<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'userPasswords']);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $password = $user->passwords()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'password' => $request->input('password')
        ]);

        return ['message' => 'Password guardo com sucesso'];
    }

    public function userPasswords(string $id)
    {
        $user = $this->getUser($id);

        if(!$user->password)
            return [];

        $passwords = $user->passwords;

        return UserResource::collection($passwords);
    }

    public function getUser(string $id)
    {
        $userTest = Auth::user();
        $user = User::find($id);

        if(!$user)
        {
            return ['message' => 'not found'];
        }
        elseif ($userTest->id !== $user->id)
        {
            return ['message' => 'Usuario diferente'];
        }
        return $user;
    }
}
