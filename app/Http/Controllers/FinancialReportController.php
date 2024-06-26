<?php

namespace App\Http\Controllers;

use App\Enums\MovementTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\PaymentMethodTypeEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinancialReportController extends Controller
{
    public function defaulters() {
        $user = auth()->user();

        $data = $user->provider->patients()
                                ->select('id', 'user_id')
                                ->withOnly('user:id,name,email,cpf_cnpj')
                                ->without('user.adresses')
                                ->with(['charges' => function($query) {
                                    return $query->where('payment_status', PaymentStatusEnum::Waiting->value)
                                                ->where('due_date', '<', now());
                                }])
                                ->whereHas('charges', function($query) {
                                    return $query->where('payment_status', PaymentStatusEnum::Waiting->value)
                                                ->where('due_date', '<', now());
                                })
                                ->withSum(['charges as total_amount_owed' => function($query) {
                                    return $query->where('payment_status', PaymentStatusEnum::Waiting->value)
                                                ->where('due_date', '<', now());
                                }], 'amount')
                                ->withCount(['charges as quantity_total_charges' => function($query) {
                                    return $query->where('payment_status', PaymentStatusEnum::Waiting->value)
                                                ->where('due_date', '<', now());
                                }])
                                ->withMax(['charges as last_charge_date' => function($query) {
                                    return $query->where('payment_status', PaymentStatusEnum::Waiting->value)
                                                ->where('due_date', '<', now());
                                }], 'due_date')
                                ->get();

        return response()->json($data, 200);
    }

    public function dashboard() {
        $user = auth()->user();

        $inOutChartData = [
            'months' => [],
            'inflows' => [],
            'outflows' => []
        ];

        for ($i=5; $i >= 0; $i--) { 
            $baseDate = now()->subMonths($i);

            array_push($inOutChartData['months'], ucwords($baseDate->locale('pt-BR')->translatedFormat('F/Y')));
            array_push($inOutChartData['inflows'], $user->financial_transactions()->whereMonth('transaction_date', $baseDate->month)->whereYear('transaction_date', $baseDate->year)->where('movement_type', MovementTypeEnum::Credit->value)->get()->sum('amount'));
            array_push($inOutChartData['outflows'], $user->financial_transactions()->whereMonth('transaction_date', $baseDate->month)->whereYear('transaction_date', $baseDate->year)->where('movement_type', MovementTypeEnum::Debit->value)->get()->sum('amount'));
        }
        
        $paymentMethodsMostUsed = [
            'payment_methods' => PaymentMethodTypeEnum::cases(),
            'count' => []
        ];

        foreach ($paymentMethodsMostUsed['payment_methods'] as $paymentMethod) {
            array_push($paymentMethodsMostUsed['count'], $user->provider->charges()->where('payment_method', $paymentMethod)->get()->count());
        }

        $data = [
            'inflows' => $user->inflows(),
            'outflows' => $user->outflows(),
            'pending' => $user->pendingProfit(),
            'balance' => $user->balance(),
            'in_out_chart_data' => $inOutChartData,
            'payment_methods_most_used' => $paymentMethodsMostUsed
        ];

        return response()->json($data, 200);
    }
}
