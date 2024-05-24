<?php

namespace App\Data\PagSeguro\Request;

use App\Models\Address;
use Spatie\DataTransferObject\DataTransferObject;

class AddressDTO extends DataTransferObject
{
    public string $street;
    public string $number;
    public string | null $complement;
    public string $locality;
    public string $city;
    public string $region;
    public string $region_code;
    public string $country;
    public string $postal_code;

    public static function fromModel(Address $model) {
        return new self([
            'postal_code' => $model->postal_code,
            'street' => $model->street,
            'locality' => $model->locality,
            'city' => $model->city,
            'region' => $model->city,
            'region_code' => $model->region_code,
            'country' => 'BRA',
            'number' => $model->number,
            'complement' => $model->complement ? str_replace(' ', '', $model->complement) : null
        ]);
    }
}