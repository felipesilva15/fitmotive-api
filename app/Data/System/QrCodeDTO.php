<?php

namespace App\Data\System;

use App\Data\System\AddressDTO;
use App\Models\QrCode;
use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class QrCodeDTO extends DataTransferObject
{
    public int $id;
    public int $charge_id;
    public string $bank_gateway_id;
    public string $image_uri;
    public float $amount;
    public string $text;
    public string $expiration_date;

    public static function fromModel(QrCode $model) {
        return new self([
            'id' => $model->id,
            'charge_id' => $model->charge_id,
            'bank_gateway_id' => $model->bank_gateway_id,
            'image_uri' => $model->image_uri,
            'text' => $model->text,
            'amount' => $model->amount,
            'expiration_date' => Carbon::create($model->expiration_date)->toISOString()
        ]);
    }
}