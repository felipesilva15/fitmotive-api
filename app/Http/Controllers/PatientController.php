<?php

namespace App\Http\Controllers;

use App\Data\System\PatientDTO;
use App\Enums\CrudActionEnum;
use App\Exceptions\MasterNotFoundHttpException;
use App\Helpers\Utils;
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
        $this->dto = PatientDTO::class;
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

    public function destroy($id) {
        $data = $this->model::find($id);

        if (!$data) {
            throw new MasterNotFoundHttpException;
        }

        $data->user()->delete();

        return response()->json(['message' => 'Registro deletado com sucesso!'], 200);
    }

    public function update(Request $request, $id) {
        $data = $request->validate(PatientDTO::rules());
        $patient = $this->model::find($id);

        if (!$patient) {
            throw new MasterNotFoundHttpException;
        }

        if (isset($data['phones'])) {
            $data['phones'] = Utils::defineCrudActionOnArray($patient->user->phones, $data['phones']);
        }

        if (isset($data['adresses'])) {
            $data['adresses'] = Utils::defineCrudActionOnArray($patient->user->adresses, $data['adresses']);
        }

        if (isset($data['payment_methods'])) {
            $data['payment_methods'] = Utils::defineCrudActionOnArray($patient->user->payment_methods, $data['payment_methods']);
        }

        DB::transaction(function () use ($patient, $data) {
            $user = $patient->user()->update();

            if (isset($data['phones'])) {
                foreach ($data['phones'] as $phone) {
                    switch ($phone['action']) {
                        case CrudActionEnum::Create:
                            $user->phones()->create($phone);
                            break;

                        case CrudActionEnum::Update:
                            $user->phones()->update($phone);
                            break;

                        case CrudActionEnum::Delete:
                            $user->phones()->detach($phone);
                            break;
                    }
                }
            }
            
            if (isset($data['adresses'])) {
                foreach ($data['adresses'] as $address) {
                    switch ($address['action']) {
                        case CrudActionEnum::Create:
                            $user->adresses()->create($address);
                            break;

                        case CrudActionEnum::Update:
                            $user->adresses()->update($address);
                            break;

                        case CrudActionEnum::Delete:
                            $user->adresses()->detach($address);
                            break;
                    }
                }
            }

            if (isset($data['payment_methods'])) {
                foreach ($data['payment_methods'] as $paymentMethod) {
                    switch ($paymentMethod['action']) {
                        case CrudActionEnum::Create:
                            $user->payment_methods()->create($paymentMethod);
                            break;

                        case CrudActionEnum::Update:
                            $user->payment_methods()->update($paymentMethod);
                            break;

                        case CrudActionEnum::Delete:
                            $user->payment_methods()->detach($paymentMethod);
                            break;
                    }
                }
            }

            $patient->update($data);

            return $patient;
        });

        $data = $this->model::find($patient->id);
        $data = PatientDTO::fromModel($data);

        return response()->json($data, 201);
    }
}
