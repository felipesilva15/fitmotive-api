<?php

namespace App\Data\PagSeguro\Response;

use App\Enums\PaymentStatusEnum;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class SubscriptionInvoicesResponseDTO extends DataTransferObject
{
    #[CastWith(ArrayCaster::class, itemType: InvoiceResponseDTO::class)]
    public array | null $invoices;
}