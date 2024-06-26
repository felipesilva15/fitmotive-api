<?php

namespace App\Models;

use App\Enums\BillingRecurrenceEnum;
use App\Enums\MovementTypeEnum;
use App\Enums\PaymentMethodTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Enums\ProviderProfessionEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf_cnpj',
        'birth_date',
        'bank_gateway_id',
        'inactive'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'inactive' => 'boolean'
    ];

    protected $with = [
        'provider'
    ];

    public function phones(): HasMany {
        return $this->hasMany(Phone::class);
    }

    public function phone(): HasOne {
        return $this->phones()->one()->ofMany('main');
    }

    public function adresses(): HasMany {
        return $this->hasMany(Address::class);
    }

    public function address(): HasOne {
        return $this->adresses()->one()->ofMany('main');
    }

    public function payment_methods(): HasMany {
        return $this->hasMany(PaymentMethod::class);
    }

    public function payment_method(): HasOne {
        return $this->payment_methods()->one()->ofMany('main');
    }

    public function provider(): HasOne {
        return $this->hasOne(Provider::class);
    } 

    public function patient(): HasOne {
        return $this->hasOne(Patient::class);
    }

    public function financial_transactions(): HasMany {
        return $this->hasMany(FinancialTransaction::class);
    }

    public function logs(): HasMany {
        return $this->hasMany(Log::class);
    }

    public function inflows (): float {
        return $this->financial_transactions()->where('movement_type', MovementTypeEnum::Credit->value)->get()->sum('amount');
    }

    public function outflows (): float {
        return $this->financial_transactions()->where('movement_type', MovementTypeEnum::Debit->value)->get()->sum('amount');
    }

    public function balance (): float {
        return $this->inflows() - $this->outflows(); 
    }

    public function pendingProfit (): float {
        return $this->provider->charges()->where('payment_status', PaymentStatusEnum::Waiting)->get()->sum('amount');; 
    }

    public static function label(): string {
        return 'usuário';
    }

    public static function rules(User $user = null): array {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(isset($user->id) ? $user->id : 0)],
            'password' => 'required|string|min:3',
            'cpf_cnpj' => ['required', 'string', 'min:11','max:14', Rule::unique('users')->ignore(isset($user->id) ? $user->id : 0)],
            'birth_date' => 'required|date',
            'bank_gateway_id' => 'string|max:60',
            'inactive' => 'boolean',
            'phones' => 'nullable|array',
            'phones.*.country' => Phone::rules()['country'],
            'phones.*.ddd' => Phone::rules()['ddd'],
            'phones.*.number' => Phone::rules()['number'],
            'phones.*.type' => Phone::rules()['type'],
            'phones.*.main' => Phone::rules()['main'],
            'adresses' => 'nullable|array',
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
            'payment_methods.*.type' => PaymentMethod::rules()['type'],
            'payment_methods.*.card_number' => 'required_if:payment_methods.*.type,'.PaymentMethodTypeEnum::CreditCard->value.'|string|max:21',
            'payment_methods.*.network_token' => PaymentMethod::rules()['network_token'],
            'payment_methods.*.exp_month' => 'required_if:payment_methods.*.type,'.PaymentMethodTypeEnum::CreditCard->value.'|string|max:2',
            'payment_methods.*.exp_year' => 'required_if:payment_methods.*.type,'.PaymentMethodTypeEnum::CreditCard->value.'|string|max:4',
            'payment_methods.*.security_code' => 'required_if:payment_methods.*.type,'.PaymentMethodTypeEnum::CreditCard->value.'|string|max:3',
            'payment_methods.*.main' => PaymentMethod::rules()['main'],
            'provider' => 'nullable',
            'provider.plan_id' => 'required_with:provider|int',
            'provider.profession' => ['required_with:provider', Rule::enum(ProviderProfessionEnum::class)],
            'provider.bank_gateway_id' => 'string|max:60',
            'provider.inactive' => 'boolean',
            'patient' => 'nullable',
            'patient.provider_id' => 'required_with:patient|int',
            'patient.service_price' => 'required_with:patient|decimal:0,2',
            'patient.billing_recurrence' => ['required_with:patient', Rule::enum(BillingRecurrenceEnum::class)],
        ];
    }

    public function getJWTIdentifier(): mixed {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array {
        return [];
    }
}
