<?php

namespace App\Models;

use App\Enums\PaymentMethodTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule as ValidationRule;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'card_number',
        'network_token',
        'exp_month',
        'exp_year',
        'security_code',
        'main'
    ];

    protected $cast = [
        'main' => 'boolean',
        'type' => PaymentMethodTypeEnum::class
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function rules(): array {
        return [
            'user_id' => 'required|int',
            'type' => ['required', ValidationRule::enum(PaymentMethodTypeEnum::class)],
            'card_number' => 'required_if:type,'.PaymentMethodTypeEnum::CreditCard->value.','.PaymentMethodTypeEnum::DebitCard->value.'|string|max:21',
            'network_token' => 'string|max:40',
            'exp_month' => 'required_if:type,'.PaymentMethodTypeEnum::CreditCard->value.','.PaymentMethodTypeEnum::DebitCard->value.'|string|max:2',
            'exp_year' => 'required_if:type,'.PaymentMethodTypeEnum::CreditCard->value.','.PaymentMethodTypeEnum::DebitCard->value.'|string|max:4',
            'security_code' => 'required_if:type,'.PaymentMethodTypeEnum::CreditCard->value.','.PaymentMethodTypeEnum::DebitCard->value.'|string|max:3',
            'main' => 'boolean'
        ];
    }
}
