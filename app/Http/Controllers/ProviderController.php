<?php

namespace App\Http\Controllers;

use App\Data\System\ChargeDTO;
use App\Models\Provider;
use App\Services\System\ProviderService;
use Illuminate\Http\Request;
use App\Helpers\Utils;
use App\Data\System\PatientDTO;
use App\Data\System\ProviderDTO;
use App\Enums\LogActionEnum;
use App\Enums\MovementTypeEnum;
use App\Exceptions\MasterNotFoundHttpException;
use App\Models\User;
use App\Services\System\LogService;
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

            LogService::log('Cadastro de prestador (ID '.$provider->id.')', LogActionEnum::Create);

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

    public function financialTransactions(int $id, Request $request) {
        $provider = Provider::find($id);

        if (!$provider) {
            throw new MasterNotFoundHttpException;
        }

        $transactions = $provider->user->financial_transactions()
                                        ->orderBy('transaction_date')
                                        ->get();

        $credit = $transactions->sum(function($transaction) {
            return $transaction->movement_type == MovementTypeEnum::Credit->value ? $transaction->amount : 0;
        });

        $debit = $transactions->sum(function($transaction) {
            return $transaction->movement_type == MovementTypeEnum::Debit->value ? $transaction->amount : 0;
        });

        $currentBalance = $credit - $debit;

        $data = [
            'data' => $transactions,
            'totalizers' => [
                'previous_balance' => 0,
                'credit' => $credit,
                'debit' => $debit,
                'current_balance' => $currentBalance
            ]
        ];

        return response()->json($data, 200);
    }
}
