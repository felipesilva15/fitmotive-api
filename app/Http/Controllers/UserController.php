<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(User $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    public function store(Request $request) {
        $request->validate(User::rules());

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        
        $data = User::create($data);

        return response()->json($data, 201);
    }

    public function update(Request $request, $id) {
        $request->validate(User::rulesUpdate());

        $user = Auth::user();

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);

        $user->update($data);

        return response()->json($data, 200);
    }
}
