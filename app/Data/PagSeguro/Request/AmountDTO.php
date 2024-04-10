<?php

namespace App\Data\PagSeguro\Request;

use App\Enums\CurrencyEnum;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class AmountDTO extends DataTransferObject
{
    #[CastWith(EnumCaster::class, CurrencyEnum::class)]
    public CurrencyEnum $currency = CurrencyEnum::Real;
    public int $value;
}