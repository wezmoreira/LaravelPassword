<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct(
        UserService $service
    )
    {
        $this->middleware('auth:sanctum')->only(['delete', 'show', 'update', 'index']);
        $this->service = $service;
    }
    protected UserService $service;

    public function index()
    {
        $user = User::paginate();

        return new UserResource($user);
    }

    public function store(StoreUserRequest $request)
    {
        return new UserResource($this->service->storeUser($request));
    }

    public function show(string $id)
    {
        return new UserResource($this->service->showUser($id));
    }

    public function update(StoreUserRequest $request, string $id)
    {
        return new UserResource($this->service->updateUser($request, $id));
    }

    public function delete(string $id)
    {
        $this->service->deleteUser($id);

        return response()->json([], 204);
    }
}
