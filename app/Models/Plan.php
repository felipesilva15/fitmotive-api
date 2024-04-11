<?php

namespace App\Models;

use App\Enums\PlanBillingIntervalEnum;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule as ValidationRule;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'trial_days',
        'billing_interval',
        'bank_gateway_id'
    ];

    protected $casts = [
        'billing_interval' => PlanBillingIntervalEnum::class
    ];

    public static function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'description' => 'string',
            'price' => 'required|decimal:0,2',
            'trial_days' => 'integer',
            'billing_interval' => ['required', ValidationRule::enum(PlanBillingIntervalEnum::class)],
            'bank_gateway_id' => 'string|max:60'
        ];
    }
}
