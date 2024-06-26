<?php

namespace App\Http\Controllers;

use App\Enums\MovementTypeEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    public function index() {
        $user = auth()->user();

        $currentMonthProfit = $user->financial_transactions()->whereMonth('transaction_date', now()->month)->where('movement_type', MovementTypeEnum::Credit->value)->get()->sum('amount');
        $currentMonthPendingProfit = $user->provider->charges()->whereMonth('due_date', now()->month)->where('payment_status', PaymentStatusEnum::Waiting)->get()->sum('amount');
        $lastMonthProfit = $user->financial_transactions()->whereMonth('transaction_date', now()->subMonth()->month)->where('movement_type', MovementTypeEnum::Credit->value)->get()->sum('amount');

        $totalProfit = $user->provider->charges()->where(function(Builder $query) {
            return $query->where('payment_status', '<>', PaymentStatusEnum::Canceled->value)
                            ->orWhere('payment_status', '<>', PaymentStatusEnum::Declined->value);
        })->get()->sum('amount');

        $patients = $user->provider->patients->sortBy('created_at');

        $patients = collect($patients)->map(function($patient) {
            $patient->created_at = $patient->created_at->format('Y-m');

            return $patient;
        });

        $patientsChartData = [
            'months' => [],
            'total' => [],
            'new' => []
        ];

        for ($i=11; $i >= 0; $i--) { 
            $baseDate = now()->subMonths($i);

            array_push($patientsChartData['months'], ucwords($baseDate->locale('pt-BR')->translatedFormat('F/Y')));
            array_push($patientsChartData['total'], $user->provider->patients()->whereMonth('created_at', '<=', $baseDate->month)->whereYear('created_at', '<=', $baseDate->year)->get()->count());
            array_push($patientsChartData['new'], $user->provider->patients()->whereMonth('created_at', $baseDate->month)->whereYear('created_at', $baseDate->year)->get()->count());
        }

        $data = [
            "patients" => [
                "count" => $user->provider->patients->count(),
                "new_this_month" => $user->provider->patients()->whereMonth('created_at', now()->month)->count(),
                "overview_chart_data" => $patientsChartData
            ],
            "workouts" => [
                "count" => $user->provider->workouts->count(),
                "new_this_month" => $user->provider->workouts()->whereMonth('created_at', now()->month)->count(),
            ],
            "monthly_profit" => [
                'amount' => $currentMonthProfit,
                'pending' => $currentMonthPendingProfit,
                'percent' => $lastMonthProfit != 0 ? 100 / $lastMonthProfit * ($currentMonthProfit - $lastMonthProfit) : 0
            ],
            "pending_profit" => [
                'amount' => $user->pendingProfit(),
                'percent' => $totalProfit != 0 ? 100 / $totalProfit * $user->pendingProfit() : 0
            ]
        ];

        return response()->json($data, 200);
    }
}
