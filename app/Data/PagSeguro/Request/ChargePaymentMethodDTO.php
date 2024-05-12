<?php

namespace App\Data\PagSeguro\Request;

use App\Enums\PaymentMethodTypeEnum;
use App\Models\PaymentMethod;
use Spatie\DataTransferObject\DataTransferObject;

class ChargePaymentMethodDTO extends DataTransferObject
{
    public string $type;
    public int $installments;
    public string $soft_descriptor;
    public PaymentCardDTO | null $card;
    public object | null $boleto;

    public static function fromModel(PaymentMethod $model) {
        return new self([
            'type' => $model->type,
            'card' => $model->type == PaymentMethodTypeEnum::CreditCard->value ? PaymentCardDTO::fromModel($model) : null
        ]);
    }
}