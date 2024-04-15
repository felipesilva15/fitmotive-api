<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\System\AuthService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct(User $model, Request $request) {
        $this->service = new AuthService($model, $request);
        $this->request = $request;
    }

    public function login() {
        $credentials = request(['email', 'password']);
        $token = $this->service->login($credentials);

        return $this->respondWithToken($token);
    }

    public function me() {
        return response()->json($this->service->me(), 200);
    }

    public function logout() {
        $this->service->logout();

        return response()->json(["message" => "Logout efetuado com sucesso."], 200);
    }

    public function refresh() {
        return $this->respondWithToken($this->service->refresh());
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ], 200);
    }
}