<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct(User $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    public function store(Request $request) {
        $data = $request->validate($this->model::rules());

        $user = DB::transaction(function () use ($data) {
            $user = User::create($data);

            if (isset($data['adresses'])) {
                foreach ($data['phones'] as $phone) {
                    $user->phones()->create($phone);
                }
            }
            
            if (isset($data['adresses'])) {
                foreach ($data['adresses'] as $address) {
                    $user->adresses()->create($address);
                }
            }

            if (isset($data['payment_methods'])) {
                foreach ($data['payment_methods'] as $paymentMethod) {
                    $user->payment_methods()->create($paymentMethod);
                }
            }

            if (isset($data['provider'])) {
                $user->provider()->create($data['provider']);
            }

            if (isset($data['patient'])) {
                $user->patient()->create($data['patient']);
            }

            return $user;
        });

        $data = $this->model::find($user->id);

        return response()->json($data, 201);
    }
}
