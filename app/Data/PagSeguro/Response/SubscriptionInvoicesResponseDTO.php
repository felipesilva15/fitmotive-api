<?php

namespace App\Data\PagSeguro\Response;

use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\DataTransferObject;

class SubscriptionInvoicesResponseDTO extends DataTransferObject
{
    #[CastWith(ArrayCaster::class, itemType: InvoiceResponseDTO::class)]
    public array | null $invoices;
}