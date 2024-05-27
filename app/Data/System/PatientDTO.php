<?php

namespace App\Data\System;

use App\Enums\BillingRecurrenceEnum;
use App\Enums\PaymentMethodTypeEnum;
use App\Helpers\Utils;
use App\Models\Address;
use App\Models\Patient;
use App\Models\PaymentMethod;
use App\Models\Phone;
use Illuminate\Validation\Rule;
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

    public static function rules($patient = null): array {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(isset($patient->user_id) ? $patient->user_id : 0)],
            'cpf_cnpj' => ['required', 'string', 'min:11','max:14', Rule::unique('users')->ignore(isset($patient->user_id) ? $patient->user_id : 0)],
            'password' => 'string|min:3',
            'birth_date' => 'required|date',
            'bank_gateway_id' => 'nullable|string|max:60',
            'provider_id' => 'required|int',
            'service_price' => 'required|decimal:0,2',
            'billing_recurrence' => ['required:', Rule::enum(BillingRecurrenceEnum::class)],
            'inactive' => 'boolean',
            'phones' => 'required|array|min:1',
            'phones.*.id' => 'nullable|int',
            'phones.*.country' => Phone::rules()['country'],
            'phones.*.ddd' => Phone::rules()['ddd'],
            'phones.*.number' => Phone::rules()['number'],
            'phones.*.type' => Phone::rules()['type'],
            'phones.*.main' => Phone::rules()['main'],
            'adresses' => 'required|array|min:1',
            'adresses.*.id' => 'nullable|int',
            'adresses.*.name' => Address::rules()['name'],
            'adresses.*.postal_code' => Address::rules()['postal_code'],
            'adresses.*.street' => Address::rules()['street'],
            'adresses.*.locality' => Address::rules()['locality'],
            'adresses.*.city' => Address::rules()['city'],
            'adresses.*.region' => Address::rules()['region'],
            'adresses.*.region_code' => Address::rules()['region_code'],
            'adresses.*.number' => Address::rules()['number'],
            'adresses.*.complement' => Address::rules()['complement'],
            'adresses.*.main' => Address::rules()['main'],
            'payment_methods' => 'required|array|min:1',
            'payment_methods.*.id' => 'nullable|int',
            'payment_methods.*.type' => PaymentMethod::rules()['type'],
            'payment_methods.*.card_number' => 'required_if:payment_methods.*.type,'.PaymentMethodTypeEnum::CreditCard->value.'|nullable|string|max:21',
            'payment_methods.*.network_token' => PaymentMethod::rules()['network_token'],
            'payment_methods.*.exp_month' => 'required_if:payment_methods.*.type,'.PaymentMethodTypeEnum::CreditCard->value.'|nullable|string|max:2',
            'payment_methods.*.exp_year' => 'required_if:payment_methods.*.type,'.PaymentMethodTypeEnum::CreditCard->value.'|nullable|string|max:4',
            'payment_methods.*.security_code' => 'required_if:payment_methods.*.type,'.PaymentMethodTypeEnum::CreditCard->value.'|nullable|string|max:3',
            'payment_methods.*.main' => PaymentMethod::rules()['main'],
        ];
    } 
}