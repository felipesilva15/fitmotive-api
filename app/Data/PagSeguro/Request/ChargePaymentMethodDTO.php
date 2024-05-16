<?php

namespace App\Data\PagSeguro\Request;

use App\Enums\PaymentMethodTypeEnum;
use App\Models\Charge;
use App\Models\PaymentMethod;
use Spatie\DataTransferObject\DataTransferObject;

class ChargePaymentMethodDTO extends DataTransferObject
{
    public string $type;
    public int $installments;
    public bool $capture;
    public string $soft_descriptor;
    public PaymentCardDTO | null $card;
    public object | null $boleto;

    public static function fromModel(Charge $model) {
        return new self([
            'type' => $model->patient->user->payment_method->type,
            'installments' => 1,
            'capture' => false,
            'soft_descriptor' => 'Servico de saude',
            'card' => $model->patient->user->payment_method->type == PaymentMethodTypeEnum::CreditCard->value ? CardDTO::fromModel($model->patient->user->payment_method) : null,
            'boleto' => $model->patient->user->payment_method->type == PaymentMethodTypeEnum::Boleto->value ? BoletoDTO::fromModel($model) : null
        ]);
    }
}