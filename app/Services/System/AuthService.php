<?php

namespace App\Services\System;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService extends Service
{
    public function __construct(User $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    public function login($credentials) {
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(["message" => "Credenciais inválidas."], 401);
        }

        return $token;
    }

    public function me() {
        return auth()->user();
    }

    public function logout(): void {
        auth()->logout();
    }

    public function refresh() {
        return auth()->refresh();
    }
}