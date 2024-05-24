<?php

namespace App\Data\PagSeguro\Request;

use App\Enums\PhoneTypeEnum;
use App\Models\Phone;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class PhoneDTO extends DataTransferObject
{
    public string $area;
    public string $country;
    public string $number;
    #[CastWith(EnumCaster::class, PhoneTypeEnum::class)]
    public PhoneTypeEnum $type;

    public static function fromModel(Phone $model) {
        return new self([
            'area' => $model->ddd,
            'country' => $model->country,
            'number' => $model->number,
            'type' => $model->type
        ]);
    }
}