<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\System\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(User $model, Request $request) {
        $this->service = new UserService($model, $request);
        $this->request = $request;
    }
}
