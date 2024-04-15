<?php

namespace App\Services\System;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService extends Service
{
    public function __construct(User $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }
}