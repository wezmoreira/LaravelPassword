<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['delete', 'show', 'update', 'index']);
    }

    public function index()
    {
        $user = User::paginate();

        return new UserResource($user);
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        $user = User::create($data);

        return new UserResource($user);
    }

    public function show(string $id)
    {
        //$user = User::findOrFail($id);
        $user = $this->getUser($id);
        return new UserResource($user);
    }

    public function update(StoreUserRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validated();

        if($request->password)
        {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return new UserResource($user);
    }

    public function delete(string $id)
    {
        $user = User::findOrFail($id)->delete(); //TODO - verificar metodo findOrFail()

        return response()->json([], 204);
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
            //return response()->json(['message' => 'Usuario não permitido'], 403);
        }
        return $user;
    }

}
