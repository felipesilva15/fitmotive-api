<?php

namespace App\Data\PagSeguro\Request;

use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class CardHolderDTO extends DataTransferObject
{
    public string $name;
    public string $birth_date;
    public string $tax_id;
    public PhoneDTO $phone;

    public static function fromModel(User $model) {
        return new self([
            'name' => preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities(trim($model->name))),
            'birth_date' => $model->birth_date,
            'tax_id' => $model->cpf_cnpj,
            'phone' => PhoneDTO::fromModel($model->phone)
        ]);
    }
}