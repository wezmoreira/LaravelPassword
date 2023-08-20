<?php

namespace App\Services;

use App\Models\PasswordStore;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordService
{

    public function storePassword(Request $request)
    {
        $user = Auth::user();

        $password = $user->passwords()->create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'password' => $request->input('password')
        ]);
    }

    public function userPasswordService(string $id)
    {
        $user = $this->getUser($id);

        if(!$user->password)
            return [];

        return $user->passwords;
    }

    public function deletePasswordService($id)
    {
        $user = Auth::user();
        $password = PasswordStore::find($id);

        if (!$password) {
            return ['message' => 'Password não encontrado'];
        }
        if ($user->id !== $password->user_id) {
            return ['message' => 'Não Autorizado!'];

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
