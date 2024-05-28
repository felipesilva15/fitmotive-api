<?php

namespace App\Data\PagSeguro\Response;

use App\Data\PagSeguro\Request\AmountDTO;
use App\Enums\PaymentStatusEnum;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class InvoiceResponseDTO extends DataTransferObject
{
    public string | null $id;
    #[CastWith(EnumCaster::class, PaymentStatusEnum::class)]
    public PaymentStatusEnum | null $status;
    public AmountDTO | null $amount;
    public int | null $ocurrence;
    public string | null $created_at;
    public string | null $updated_at;
}