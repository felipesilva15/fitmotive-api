<?php

namespace App\Data\System;

use App\Enums\ChargeLinkReferenceEnum;
use App\Enums\ResponseTypeEnum;
use App\Models\ChargeLink;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class ChargeLinkDTO extends DataTransferObject
{
    public int | null $id;
    public int $charge_id;
    #[CastWith(EnumCaster::class, ChargeLinkReferenceEnum::class)]
    public ChargeLinkReferenceEnum $reference;
    public string $uri;
    #[CastWith(EnumCaster::class, ResponseTypeEnum::class)]
    public ResponseTypeEnum $response_type;
    public string | null $created_at;
    public string | null $updated_at;

    public static function fromModel(ChargeLink $model) {
        return new self([
            'id' => $model->id,
            'charge_id' => $model->charge_id,
            'reference' => $model->reference,
            'uri' => $model->uri,
            'response_type' => $model->response_type,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ]);
    }
}