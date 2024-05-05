<?php

namespace App\Data\PagSeguro\Request;

use App\Enums\PaymentMethodTypeEnum;
use App\Helpers\Utils;
use App\Models\User;
use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class SubscriberDTO extends DataTransferObject
{
    public string $name;
    public string $email;
    public string $tax_id;
    public array $phones;
    public string $birth_date;
    public AddressDTO $address;
    public array | null $billing_info;

    public static function fromModel(User $model) {
        return new self([
            'name' => $model->name,
            'email' => $model->email,
            'tax_id' => $model->cpf_cnpj,
            'phones' => Utils::modelCollectionToDtoCollection($model->phones, PhoneDTO::class)->toArray(),
            'birth_date' => $model->birth_date,
            'address' => AddressDTO::fromModel($model->address),
            'billing_info' => $model->payment_method->type == PaymentMethodTypeEnum::CreditCard->value ? [BillingInfoDTO::fromModel($model->payment_method)] : null
        ]);
    }
}