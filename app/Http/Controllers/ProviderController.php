<?php

namespace App\Http\Controllers;

use App\Data\System\ChargeDTO;
use App\Models\Provider;
use App\Services\System\ProviderService;
use Illuminate\Http\Request;
use App\Helpers\Utils;
use App\Data\System\PatientDTO;
use App\Data\System\ProviderDTO;
use App\Exceptions\MasterNotFoundHttpException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProviderController extends Controller
{
    public function __construct(Provider $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
        $this->dto = ProviderDTO::class;
    }

    public function store(Request $request) {
        $data = $request->validate(ProviderDTO::rules());

        $provider = DB::transaction(function () use ($data) {
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

            $provider = $user->provider()->create($data);

            return $provider;
        });

        $data = $this->model::find($provider->id);
        $data = ProviderDTO::fromModel($data);

        return response()->json($data, 201);
    }

    public function patients(int $id) {
        $provider = Provider::find($id);

        if (!$provider) {
            throw new MasterNotFoundHttpException;
        }

        $data = Utils::modelCollectionToDtoCollection($provider->patients, PatientDTO::class);

        return response()->json($data->sortByDesc('id')->values()->all(), 200);
    }

    public function charges(int $id) {
        $provider = Provider::find($id);

        if (!$provider) {
            throw new MasterNotFoundHttpException;
        }

        $data = Utils::modelCollectionToDtoCollection($provider->charges, ChargeDTO::class);

        return response()->json($data->sortByDesc('id')->values()->all(), 200);
    }

    public function financialTransactions(int $id) {
        $provider = Provider::find($id);

        if (!$provider) {
            throw new MasterNotFoundHttpException;
        }

        $data = $provider->user->financial_transactions;

        return response()->json($data->sortBy('transaction_date')->values()->all(), 200);
    }
}
