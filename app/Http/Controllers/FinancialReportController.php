<?php

namespace App\Http\Controllers;

use App\Enums\MovementTypeEnum;
use App\Enums\PaymentStatusEnum;
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
                                    return $query->where('payment_status', '<>', PaymentStatusEnum::Paid->value)
                                                ->where('due_date', '<', now());
                                }])
                                ->whereHas('charges', function($query) {
                                    return $query->where('payment_status', '<>', PaymentStatusEnum::Paid->value)
                                                ->where('due_date', '<', now());
                                })
                                ->withSum(['charges as total_amount_owed' => function($query) {
                                    return $query->where('payment_status', '<>', PaymentStatusEnum::Paid->value)
                                                ->where('due_date', '<', now());
                                }], 'amount')
                                ->withCount(['charges as quantity_total_charges' => function($query) {
                                    return $query->where('payment_status', '<>', PaymentStatusEnum::Paid->value)
                                                ->where('due_date', '<', now());
                                }])
                                ->withMax(['charges as last_charge_date' => function($query) {
                                    return $query->where('payment_status', '<>', PaymentStatusEnum::Paid->value)
                                                ->where('due_date', '<', now());
                                }], 'due_date')
                                ->get();

        return response()->json($data, 200);
    }

    public function dashboard() {
        $user = auth()->user();

        $inflows = $user->financial_transactions()->where('movement_type', MovementTypeEnum::Credit->value)->get()->sum('amount');
        $outflows = $user->financial_transactions()->where('movement_type', MovementTypeEnum::Debit->value)->get()->sum('amount');
        $pending = $user->provider->charges()->where('payment_status', '<>',PaymentStatusEnum::Paid)->get()->sum('amount');
        $balance = $inflows - $outflows;

        $data = [
            'inflows' => $inflows,
            'outflows' => $outflows,
            'pending' => $pending,
            'balance' => $balance
        ];

        return response()->json($data, 200);
    }
}
