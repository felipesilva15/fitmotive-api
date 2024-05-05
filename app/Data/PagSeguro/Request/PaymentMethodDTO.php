<?php

namespace App\Data\PagSeguro\Request;

use App\Enums\PaymentMethodTypeEnum;
use App\Models\PaymentMethod;
use Spatie\DataTransferObject\DataTransferObject;

class PaymentMethodDTO extends DataTransferObject
{
    public string $type;
    public PaymentCardDTO | null $card;

    public static function fromModel(PaymentMethod $model) {
        return new self([
            'type' => $model->type,
            'card' => $model->type == PaymentMethodTypeEnum::CreditCard->value ? PaymentCardDTO::fromModel($model) : null
        ]);
    }
}