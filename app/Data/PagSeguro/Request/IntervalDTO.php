<?php

namespace App\Data\PagSeguro\Request;

use App\Enums\PlanPeriodEnum;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class IntervalDTO extends DataTransferObject
{
    #[CastWith(EnumCaster::class, PlanPeriodEnum::class)]
    public PlanPeriodEnum $unit = PlanPeriodEnum::Monthly;
    public int $value = 1;
}