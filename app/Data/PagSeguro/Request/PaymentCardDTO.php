<?php

namespace App\Data\PagSeguro\Request;

use App\Models\PaymentMethod;
use Spatie\DataTransferObject\DataTransferObject;

class PaymentCardDTO extends DataTransferObject
{
    public string | null $security_code;

    public static function fromModel(PaymentMethod $model) {
        return new self([
            'security_code' => $model->security_code,
        ]);
    }
}