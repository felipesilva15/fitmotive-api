<?php

namespace App\Data\PagSeguro\Request;

use App\Models\Phone;
use Spatie\DataTransferObject\DataTransferObject;

class PhoneDTO extends DataTransferObject
{
    public string $area;
    public string $country;
    public string $number;

    public static function fromModel(Phone $model) {
        return new self([
            'area' => $model->ddd,
            'country' => $model->country,
            'number' => $model->number
        ]);
    }
}