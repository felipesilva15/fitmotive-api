<?php

namespace App\Data\System;

use App\Enums\PaymentMethodTypeEnum;
use App\Models\PaymentMethod;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class PaymentMethodDTO extends DataTransferObject
{
    public int | null $id;
    public int $user_id;
    #[CastWith(EnumCaster::class, PaymentMethodTypeEnum::class)]
    public PaymentMethodTypeEnum $type;
    public string | null $card_number;
    public string | null $network_number;
    public string | null $exp_month;
    public string | null $exp_year;
    public string | null $security_code;
    public bool $main;
    public string $created_at;
    public string | null $updated_at;

    public static function fromModel(PaymentMethod $model) {
        return new self($model->toArray());
    }

    public static function rules(): array {
        return PaymentMethod::rules();
    }
}