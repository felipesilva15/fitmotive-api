<?php

namespace App\Http\Controllers;

use App\Enums\LogActionEnum;
use App\Http\Controllers\Controller;
use App\Services\System\LogService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login() {
        $credentials = request(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(["message" => "Credenciais inválidas."], 401);
        }

        LogService::log('Realizou login', LogActionEnum::Other);

        return $this->respondWithToken($token);
    }

    public function me() {
        return response()->json(auth()->user());
    }

    public function logout() {
        LogService::log('Realizou logout', LogActionEnum::Other);

        auth()->logout();

        return response()->json(["message" => "Logout efetuado com sucesso."]);
    }

    public function refresh() {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}