<?php

namespace App\Data\PagSeguro\Response;

use App\Enums\PaymentStatusEnum;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class TrialResponseDTO extends DataTransferObject
{
    public string | null $end_at;
    public string | null $start_at;
}