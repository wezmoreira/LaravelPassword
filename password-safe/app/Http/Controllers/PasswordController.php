<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\PasswordStore;
use App\Models\User;
use App\Services\PasswordService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{

    public function __construct(
        PasswordService $service
    )
    {
        $this->middleware('auth:sanctum')->only(['store', 'userPasswords', 'delete']);
        $this->service = $service;
    }

    protected PasswordService $service;

    public function index()
    {
        return new UserResource([]);
    }

    public function store(Request $request)
    {
        $this->service->storePassword($request);

        return new UserResource(['message' => 'Password guardado com sucesso']);
    }

    public function userPasswords(string $id)
    {
        return UserResource::collection($this->service->userPasswordService($id));
    }

    public function delete($id)
    {
        $result = $this->service->deletePasswordService($id);

        return new UserResource([$result]);
    }
}
