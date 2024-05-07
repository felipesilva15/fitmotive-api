<?php

namespace App\Http\Controllers;

use App\Enums\MovementTypeEnum;
use App\Enums\PaymentStatusEnum;

class DashboardController extends Controller
{
    public function index() {
        $user = auth()->user();

        $currentMonthProfit = $user->financial_transactions()->whereMonth('transaction_date', now()->month)->where('movement_type', MovementTypeEnum::Credit->value)->get()->sum('amount');
        $lastMonthProfit = $user->financial_transactions()->whereMonth('transaction_date', now()->subMonth()->month)->where('movement_type', MovementTypeEnum::Credit->value)->get()->sum('amount');

        $pendingProfit = $user->provider->charges()->where('payment_status', '<>',PaymentStatusEnum::Paid)->get()->sum('amount');
        $totalProfit = $user->provider->charges()->get()->sum('amount');

        $data = [
            "patients" => [
                "count" => $user->provider->patients->count(),
                "new_this_month" => $user->provider->patients()->whereMonth('created_at', now()->month)->count(),
                //"data" => Utils::modelCollectionToDtoCollection($user->provider->patients, PatientDTO::class)
            ],
            "monthly_profit" => [
                'amount' => $currentMonthProfit,
                'percent' => $lastMonthProfit != 0 ? 100 / $lastMonthProfit * ($currentMonthProfit - $lastMonthProfit) : 0
            ],
            "pending_profit" => [
                'amount' => $pendingProfit,
                'percent' => $totalProfit != 0 ? 100 / $totalProfit * $pendingProfit : 0
            ]
        ];

        return response()->json($data, 200);
    }
}
