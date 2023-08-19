<?php

namespace App\Services;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService
{

    public function storeUser(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);

        return $user;
    }

    public function showUser(string $id)
    {
        $user = $this->getUser($id);
        return $user;
    }

    public function getUser(string $id)
    {
        $userTest = Auth::user();
        $user = User::find($id);

        if(!$user)
        {
            return ['message' => 'Não Encontrado!'];
        }
        elseif ($userTest->id !== $user->id)
        {
            return ['message' => 'Usuario diferente'];
        }
        return $user;
    }

    public function updateUser(StoreUserRequest $request, string $id)
    {
        $user = $this->getUser($id);

        $data = $request->validated();

        if($request->password)
        {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return $user;
    }

    public function deleteUser(string $id)
    {
        $user = $this->getUser($id)->delete();
    }
}
