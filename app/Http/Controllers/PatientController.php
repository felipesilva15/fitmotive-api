<?php

namespace App\Http\Controllers;

use App\Data\System\PatientDTO;
use App\Enums\CrudActionEnum;
use App\Enums\PaymentStatusEnum;
use App\Exceptions\MasterNotFoundHttpException;
use App\Helpers\Utils;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Charge;
use App\Models\Patient;
use App\Models\PaymentMethod;
use App\Models\Phone;
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
        $data = $request->validate(PatientDTO::rules($request));
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
            $user = $patient->user()->update([
                'name' => $data['name'],
                'email' => $data['email'],
                'cpf_cnpj' => $data['cpf_cnpj'],
                'birth_date' => $data['birth_date'],
                'inactive' => $data['inactive']
            ]);

            if (isset($data['phones'])) {
                foreach ($data['phones'] as $phone) {
                    switch ($phone['action']) {
                        case CrudActionEnum::Create:
                            $patient->user->phones()->create($phone);
                            break;

                        case CrudActionEnum::Update:
                            Phone::find($phone['id'])->update([
                                'country' => $phone['country'],
                                'ddd' => $phone['ddd'],
                                'number' => $phone['number'],
                                'type' => $phone['type'],
                                'main' => $phone['main']
                            ]);
                            break;

                        case CrudActionEnum::Delete:
                            Phone::find($phone['id'])->delete();
                            break;
                    }
                }
            }
            
            if (isset($data['adresses'])) {
                foreach ($data['adresses'] as $address) {
                    switch ($address['action']) {
                        case CrudActionEnum::Create:
                            $patient->user->adresses()->create($address);
                            break;

                        case CrudActionEnum::Update:
                            Address::find($address['id'])->update([
                                'name' => $address['name'],
                                'postal_code' => $address['postal_code'],
                                'street' => $address['street'],
                                'locality' => $address['locality'],
                                'city' => $address['city'],
                                'region' => $address['region'],
                                'region_code' => $address['region_code'],
                                'number' => $address['number'],
                                'complement' => $address['complement'],
                                'main' => $address['main']
                             ]);
                            break;

                        case CrudActionEnum::Delete:
                            Address::find($address['id'])->delete();
                            break;
                    }
                }
            }

            if (isset($data['payment_methods'])) {
                foreach ($data['payment_methods'] as $paymentMethod) {
                    switch ($paymentMethod['action']) {
                        case CrudActionEnum::Create:
                             $patient->user->payment_methods()->create($paymentMethod);
                            break;

                        case CrudActionEnum::Update:
                            PaymentMethod::find($paymentMethod['id'])->update([
                                'type' => $paymentMethod['type'],
                                'card_number' => $paymentMethod['card_number'],
                                'exp_month' => $paymentMethod['exp_month'],
                                'exp_year' => $paymentMethod['exp_year'],
                                'security_code' => $paymentMethod['security_code'],
                                'main' => $paymentMethod['main']
                             ]);
                            break;

                        case CrudActionEnum::Delete:
                            PaymentMethod::find($paymentMethod['id'])->delete();
                            break;
                    }
                }
            }

            $patient->update([
                'service_price' => $data['service_price'],
                'billing_recurrence' => $data['billing_recurrence']
            ]);

            return $patient;
        });

        $data = $this->model::find($patient->id);
        $data = PatientDTO::fromModel($data);

        return response()->json($data, 201);
    }

    public function generateCharge(int $id, Request $request) {
        $patient = $this->model::find($id);

        if (!$patient) {
            throw new MasterNotFoundHttpException;
        }

        $request->validate([
            'due_date' => 'required|date'
        ]);

        $data = Charge::create([
            'provider_id' => auth()->user()->provider->id,
            'patient_id' => $patient->id,
            'description' => 'Cobrança gerada automaticamente',
            'payment_method' => $patient->user->payment_method->type,
            'due_date' => $request->due_date,
            'amount' => $patient->service_price,
            'payment_status' => PaymentStatusEnum::Waiting
        ]);

        return response()->json($data, 200);
    }
}
