<?php

namespace App\Data\PagSeguro\Request;

use App\Models\PaymentMethod;
use Spatie\DataTransferObject\DataTransferObject;

class BillingInfoDTO extends DataTransferObject
{
    public string $type;
    public CardDTO $card;

    public static function fromModel(PaymentMethod $model) {
        return new self([
            'type' => $model->type,
            'card' => CardDTO::fromModel($model)
        ]);
    }
}