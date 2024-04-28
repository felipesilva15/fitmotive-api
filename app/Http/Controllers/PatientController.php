<?php

namespace App\Http\Controllers;

use App\Data\System\PatientDTO;
use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function __construct(Patient $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    public function store(Request $request) {
        $data = $request->validate(PatientDTO::rules());
        $data['password'] = '123';

        $patient = DB::transaction(function () use ($data) {
            $user = User::create($data);

            if (isset($data['phones'])) {
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

            $patient = $user->patient()->create($data);

            return $patient;
        });

        $data = $this->model::find($patient->id);
        $data = PatientDTO::fromModel($data);

        return response()->json($data, 201);
    }
}
