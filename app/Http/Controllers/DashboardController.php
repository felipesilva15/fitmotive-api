<?php

namespace App\Http\Controllers;

use App\Data\System\PatientDTO;
use App\Enums\MovementTypeEnum;
use App\Helpers\Utils;
use App\Models\FinancialTransaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $user = auth()->user();

        $currentMonthProfit = $user->financial_transactions()->whereMonth('transaction_date', now()->month)->where('movement_type', MovementTypeEnum::Credit->value)->get()->sum('amount');
        $lastMonthProfit = $user->financial_transactions()->whereMonth('transaction_date', now()->subMonth()->month)->where('movement_type', MovementTypeEnum::Credit->value)->get()->sum('amount');

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
            "pending_profit" => []
        ];

        return response()->json($data, 200);
    }
}