<?php

namespace App\Data\System;

use App\Models\Address;
use Spatie\DataTransferObject\DataTransferObject;

class AddressDTO extends DataTransferObject
{
    public int | null $id;
    public int $user_id;
    public string $name;
    public string $postal_code;
    public string $street;
    public string $locality;
    public string $city;
    public string $region;
    public string $region_code;
    public string $number;
    public string | null $complement;
    public bool $main;
    public string $created_at;
    public string | null $updated_at;

    public static function fromModel(Address $model) {
        return new self($model->toArray());
    }

    public static function rules(): array {
        return Address::rules();
    }
}