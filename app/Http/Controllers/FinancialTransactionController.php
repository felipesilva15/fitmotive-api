<?php

namespace App\Http\Controllers;

use App\Enums\MovementTypeEnum;
use App\Exceptions\CustomValidationException;
use App\Models\FinancialTransaction;
use Illuminate\Http\Request;

class FinancialTransactionController extends Controller
{
    public function __construct(FinancialTransaction $model, Request $request) {
        $this->model = $model;
        $this->request = $request;
    }

    public function withdraw(Request $request) {
        $request->validate([
            'amount' => 'required|decimal:0,2|min:0.01'
        ]);

        $user = auth()->user();

        if($request->amount > $user->balance()) {
            throw new CustomValidationException('O valor máximo disponível para saque é de R$ '.number_format($user->balance(), 2, ',', '.'));
        }

        $data = $this->model::create([
            'description' => 'Saque',
            'movement_type' => MovementTypeEnum::Debit,
            'amount' => $request->amount,
            'transaction_date' => now(),
            'user_id' => $user->id
        ]);

        return response()->json($data, 200);
    }
}
