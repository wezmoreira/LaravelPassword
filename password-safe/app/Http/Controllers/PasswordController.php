<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\PasswordStore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['store', 'userPasswords', 'delete']);
    }

    public function index()
    {
        return new UserResource([]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $password = $user->passwords()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'password' => $request->input('password')
        ]);

        return ['message' => 'Password guardado com sucesso'];
    }

    public function userPasswords(string $id)
    {
        $user = $this->getUser($id);

        if(!$user->password)
            return [];

        $passwords = $user->passwords;

        return UserResource::collection($passwords);
    }

    public function delete($id)
    {
        $user = Auth::user();
        $password = PasswordStore::find($id);

        if (!$password) {
            return ['message' => 'Password não encontrado'];
        }
        if ($user->id !== $password->user_id) {
            return ['message' => 'Unauthorized'];

        }

        $password->delete();
        return ['message' => 'Password deletado com sucesso!'];

    }

    public function getUser(string $id) //Otimizar isso
    {
        $userTest = Auth::user();
        $user = User::find($id);

        if(!$user)
        {
            return response()->json(['message' => 'Não Encontrado!']);
        }
        elseif ($userTest->id !== $user->id)
        {
            return ['message' => 'Usuario diferente'];
        }
        return $user;
    }
}
