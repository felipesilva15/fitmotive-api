<?php

namespace App\Data\PagSeguro\Request;

use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class BoletoHolderDTO extends DataTransferObject
{
    public string $name;
    public string $tax_id;
    public string $email;
    public AddressDTO $address;

    public static function fromModel(User $model) {
        return new self([
            'name' => $model->name,
            'tax_id' => $model->cpf_cnpj,
            'email' => $model->email,
            'address' => AddressDTO::fromModel($model->address)
        ]);
    }
}