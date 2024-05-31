<?php

namespace App\Data\PagSeguro\Response;

use App\Enums\CurrencyEnum;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Caster;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class AmountValueCaster implements Caster
{
    public function cast(mixed $value): float
    {
        return (float) ($value / 100);
    }
}

class AmountResponseDTO extends DataTransferObject
{
    #[CastWith(EnumCaster::class, CurrencyEnum::class)]
    public CurrencyEnum $currency = CurrencyEnum::Real;
    #[CastWith(AmountValueCaster::class)]
    public int $value;
}