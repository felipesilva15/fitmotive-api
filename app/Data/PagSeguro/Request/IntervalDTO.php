<?php

namespace App\Data\PagSeguro\Request;

use App\Enums\PlanBillingIntervalEnum;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class IntervalDTO extends DataTransferObject
{
    #[CastWith(EnumCaster::class, PlanBillingIntervalEnum::class)]
    public PlanBillingIntervalEnum $unit = PlanBillingIntervalEnum::Monthly;
    public int $value = 1;
}