<?php

namespace App\Data\PagSeguro\Request;

use App\Enums\CurrencyEnum;
use App\Enums\PaymentMethodTypeEnum;
use App\Helpers\Utils;
use App\Models\Plan;
use Spatie\DataTransferObject\DataTransferObject;

class PlanDTO extends DataTransferObject
{
    public string | null $id;
    public string $reference_id;
    public string $name;
    public string $description;
    public AmountDTO | null $amount;
    public IntervalDTO | null $interval;
    public TrialDTO | null $trial;
    public array $payment_method = [PaymentMethodTypeEnum::CreditCard->value];

    public static function fromModel(Plan $plan) {
        return new self([
            'reference_id' => $plan->id,
            'name' => $plan->name,
            'description' => $plan->description,
            'amount' => [
                'currency' => CurrencyEnum::Real,
                'value' => Utils::floatToStringBankFormat($plan->price)
            ],
            'interval' => [
                'unit' => $plan->billing_interval->value,
                'value' => 1
            ],
            'trial' => [
                'days' => $plan->trial_days,
                'enabled' => $plan->trial_days ? true : false,
                'hold_setup_fee' => false
            ],
            'payment_method' => [
                PaymentMethodTypeEnum::CreditCard->value,
                PaymentMethodTypeEnum::Boleto->value,
            ]
        ]);
    }
}