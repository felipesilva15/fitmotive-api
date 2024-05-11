<?php

namespace App\Data\PagSeguro\Request;

use App\Helpers\Utils;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class CustomerDTO extends DataTransferObject
{
    public string $name;
    public string $email;
    public string $tax_id;
    public array $phones;

    public static function fromModel(User $model) {
        return new self([
            'name' => $model->name,
            'email' => $model->email,
            'tax_id' => $model->cpf_cnpj,
            'phones' => Utils::modelCollectionToDtoCollection($model->phones, PhoneDTO::class)->toArray(),
        ]);
    }
}