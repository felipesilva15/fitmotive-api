<?php

namespace App\Data\System;

use App\Enums\PaymentMethodTypeEnum;
use App\Enums\ProviderProfessionEnum;
use App\Helpers\Utils;
use App\Models\Address;
use App\Models\PaymentMethod;
use App\Models\Phone;
use App\Models\Provider;
use Illuminate\Validation\Rule;
use Spatie\DataTransferObject\Attributes\CastWith;
use Spatie\DataTransferObject\Casters\ArrayCaster;
use Spatie\DataTransferObject\Casters\EnumCaster;
use Spatie\DataTransferObject\DataTransferObject;

class ProviderDTO extends DataTransferObject
{
    public int | null $id;
    public int $user_id;
    public int $plan_id;
    public string $name;
    public string $email;
    public string $cpf_cnpj;
    public string $birth_date;
    public string | null $bank_gateway_id;
    #[CastWith(EnumCaster::class, ProviderProfessionEnum::class)]
    public ProviderProfessionEnum $profession;
    public bool $inactive;
    #[CastWith(ArrayCaster::class, AddressDTO::class)]
    public array | null $adresses = [];
    #[CastWith(ArrayCaster::class, PhoneDTO::class)]
    public array | null $phones = [];
    #[CastWith(ArrayCaster::class, PaymentMethodDTO::class)]
    public array | null $payment_methods = [];
    public string $created_at;
    public string | null $updated_at;

    public static function fromModel(Provider $model) {
        return new self([
            'id' => $model->id,
            'user_id' => $model->user_id,
            'plan_id' => $model->plan_id,
            'name' => $model->user->name,
            'email' => $model->user->email,
            'cpf_cnpj' => $model->user->cpf_cnpj,
            'birth_date' => $model->user->birth_date,
            'bank_gateway_id' => $model->user->bank_gateway_id,
            'profession' => $model->profession,
            'inactive' => $model->user->inactive,
            'adresses' => Utils::modelCollectionToDtoCollection($model->user->adresses, AddressDTO::class),
            'phones' => Utils::modelCollectionToDtoCollection($model->user->phones, PhoneDTO::class),
            'payment_methods' => Utils::modelCollectionToDtoCollection($model->user->payment_methods, PaymentMethodDTO::class),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ]);
    }

    public static function rules($provider = null): array {
        return [
            'plan_id' => 'required|int',
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(isset($provider->user_id) ? $provider->user_id : 0)],
            'cpf_cnpj' => ['required', 'string', 'min:11','max:14', Rule::unique('users')->ignore(isset($provider->user_id) ? $provider->user_id : 0)],
            'password' => 'string|min:3',
            'birth_date' => 'required|date',
            'bank_gateway_id' => 'nullable|string|max:60',
            'profession' => ['required:', Rule::enum(ProviderProfessionEnum::class)],
            'inactive' => 'boolean',
            'phones' => 'nullable|array',
            'phones.*.id' => 'nullable|int',
            'phones.*.country' => Phone::rules()['country'],
            'phones.*.ddd' => Phone::rules()['ddd'],
            'phones.*.number' => Phone::rules()['number'],
            'phones.*.type' => Phone::rules()['type'],
            'phones.*.main' => Phone::rules()['main'],
            'adresses' => 'nullable|array',
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
            'payment_methods' => 'nullable|array',
            'payment_methods.*.id' => 'nullable|int',
            'payment_methods.*.type' => PaymentMethod::rules()['type'],
            'payment_methods.*.card_number' => 'required_if:payment_methods.*.type,'.PaymentMethodTypeEnum::CreditCard->value.','.PaymentMethodTypeEnum::DebitCard->value.'|nullable|string|max:21',
            'payment_methods.*.network_token' => PaymentMethod::rules()['network_token'],
            'payment_methods.*.exp_month' => 'required_if:payment_methods.*.type,'.PaymentMethodTypeEnum::CreditCard->value.','.PaymentMethodTypeEnum::DebitCard->value.'|nullable|string|max:2',
            'payment_methods.*.exp_year' => 'required_if:payment_methods.*.type,'.PaymentMethodTypeEnum::CreditCard->value.','.PaymentMethodTypeEnum::DebitCard->value.'|nullable|string|max:4',
            'payment_methods.*.security_code' => 'required_if:payment_methods.*.type,'.PaymentMethodTypeEnum::CreditCard->value.','.PaymentMethodTypeEnum::DebitCard->value.'|nullable|string|max:3',
            'payment_methods.*.main' => PaymentMethod::rules()['main'],
        ];
    } 
}