<?php

namespace App\Data\System;

use App\Enums\BillingRecurrenceEnum;
use App\Helpers\Utils;
use App\Models\Patient;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class PatientDTO extends DataTransferObject
{
    public int | null $id;
    public int $user_id;
    public int $provider_id;
    public string $name;
    public string $email;
    public string $cpf_cnpj;
    public string $birth_date;
    public string | null $bank_gateway_id;
    public float $service_price;
    #[CastWith(EnumCaster::class, BillingRecurrenceEnum::class)]
    public BillingRecurrenceEnum $billing_recurrence;
    public bool $inactive;

    #[CastWith(ArrayCaster::class, AddressDTO::class)]
    public array | null $adresses = [];

    #[CastWith(ArrayCaster::class, PhoneDTO::class)]
    public array | null $phones = [];

    #[CastWith(ArrayCaster::class, PaymentMethodDTO::class)]
    public array | null $payment_methods = [];

    public string $created_at;
    public string | null $updated_at;

    public static function fromModel(Patient $model) {
        return new self([
            'id' => $model->id,
            'user_id' => $model->user_id,
            'provider_id' => $model->provider_id,
            'name' => $model->user->name,
            'email' => $model->user->email,
            'cpf_cnpj' => $model->user->cpf_cnpj,
            'birth_date' => $model->user->birth_date,
            'bank_gateway_id' => $model->user->bank_gateway_id,
            'service_price' => $model->service_price,
            'billing_recurrence' => $model->billing_recurrence,
            'inactive' => $model->user->inactive,
            'adresses' => Utils::modelCollectionToDtoCollection($model->user->adresses, AddressDTO::class),
            'phones' => Utils::modelCollectionToDtoCollection($model->user->phones, PhoneDTO::class),
            'payment_methods' => Utils::modelCollectionToDtoCollection($model->user->payment_methods, PaymentMethodDTO::class),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ]);
    }

    public static function rules(): array {
        return [];
    } 
}