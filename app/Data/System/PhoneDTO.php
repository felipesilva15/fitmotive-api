<?php

namespace App\Data\System;

use App\Enums\PhoneTypeEnum;
use App\Models\Phone;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class PhoneDTO extends DataTransferObject
{
    public int | null $id;
    public int $user_id;
    public string $country;
    public string $ddd;
    public string $number;
    #[CastWith(EnumCaster::class, PhoneTypeEnum::class)]
    public PhoneTypeEnum $type;
    public bool $main;
    public string $created_at;
    public string | null $updated_at;

    public static function fromModel(Phone $model) {
        return new self($model->toArray());
    }

    public static function rules(): array {
        return Phone::rules();
    }
}