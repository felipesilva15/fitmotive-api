<?php

namespace App\Data\PagSeguro\Response;

use App\Data\PagSeguro\Request\AmountDTO;
use App\Enums\PaymentStatusEnum;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class SubscriptionResponseDTO extends DataTransferObject
{
    public string | null $id;
    public string | null $reference_id;
    public AmountResponseDTO | null $amount;
    #[CastWith(EnumCaster::class, PaymentStatusEnum::class)]
    public PaymentStatusEnum | null $status;
    public PlanDTO | null $plan;
    public TrialResponseDTO | null $trial;
    public string | null $next_invoice_at;
    public SimpleResponseDTO $customer;
    #[CastWith(ArrayCaster::class, itemType: InvoiceResponseDTO::class)]
    public array | null $invoices;
    public string | null $created_at;
    public string | null $updated_at;
}