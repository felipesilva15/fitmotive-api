<?php

namespace App\Data\PagSeguro\Request;

use App\Helpers\Utils;
use App\Models\Charge;
use Spatie\DataTransferObject\DataTransferObject;

class OrderDTO extends DataTransferObject
{
    public string $reference_id;
    public CustomerDTO $customer;
    public array $items;
    public ShippingDTO $shipping;
    public array $qr_codes;
    public array $notification_urls;
    public array $charges;

    public static function fromModel(Charge $model) {
        return new self([
            'reference_id' => $model->id,
            'customer' => CustomerDTO::fromModel($model->patient->user),
            'items' => [
                'name' => 'Cobrança de serviço',
                'quantity' => 1,
                'unit_amount' => Utils::floatToStringBankFormat($model->amount),
            ],
            'shipping' => ShippingDTO::fromModel($model->patient->user->address),
            'qr_codes' => [
                'amount' => [
                    'amount' => Utils::floatToStringBankFormat($model->amount)
                ],
                'expiration_date' => $model->due_date
            ],
            'notification_urls' => [],
            'charges' => [
                ChargeDTO::fromModel($model)
            ],
        ]);
    }
}