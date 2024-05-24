<?php

namespace App\Data\PagSeguro\Request;

use App\Enums\PaymentMethodTypeEnum;
use App\Helpers\Utils;
use App\Models\Charge;
use Carbon\Carbon;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\DataTransferObject;

class OrderDTO extends DataTransferObject
{
    public string $reference_id;
    public CustomerDTO $customer;
    public array $items;
    public ShippingDTO $shipping;
    public array $qr_codes;
    public array $notification_urls;
    public array | null $charges;

    public static function fromModel(Charge $model) {
        return new self([
            'reference_id' => $model->id,
            'customer' => CustomerDTO::fromModel($model->patient->user),
            'items' => [
                new OrderItemDTO([
                    'name' => 'Cobrança de serviço',
                    'quantity' => 1,
                    'unit_amount' => Utils::floatToStringBankFormat($model->amount),
                ])
            ],
            'shipping' => ShippingDTO::fromModel($model->patient->user->address),
            'qr_codes' => [
                new QrCodeDTO([
                    'amount' => [
                        'value' => Utils::floatToStringBankFormat($model->amount)
                    ],
                    'expiration_date' => Carbon::create($model->due_date)->toISOString()
                ])
            ],
            'notification_urls' => [],
            'charges' => $model->payment_method == PaymentMethodTypeEnum::PIX->value ? null : [ChargeDTO::fromModel($model)],
        ]);
    }
}