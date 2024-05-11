<?php

namespace App\Data\PagSeguro\Request;

use App\Data\PagSeguro\Request\AddressDTO;
use App\Models\Address;
use Spatie\DataTransferObject\DataTransferObject;

class ShippingDTO extends DataTransferObject
{
    public AddressDTO $address;

    public static function fromModel(Address $model) {
        return new self([
            'address' => AddressDTO::fromModel($model)
        ]);
    }
}