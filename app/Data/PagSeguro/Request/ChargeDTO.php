<?php

namespace App\Data\PagSeguro\Request;

use App\Helpers\Utils;
use App\Models\Charge;
use Spatie\DataTransferObject\DataTransferObject;

class ChargeDTO extends DataTransferObject
{
    public string $reference_id;
    public string $description;
    public AmountDTO $amount;
    public ChargePaymentMethodDTO $payment_method;
    public array | null $notification_urls;

    public static function fromModel(Charge $model) {
        return new self([
            'reference_id' => $model->id,
            'description' => 'Cobrança de serviço',
            'reference_id' => $model->id,
            'amount' => [
                'value' => Utils::floatToStringBankFormat($model->amount)
            ],
            'payment_method' => ChargePaymentMethodDTO::fromModel($model)
        ]);
    }
}