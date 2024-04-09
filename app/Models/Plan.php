<?php

namespace App\Models;

use App\Enums\PlanPeriodEnum;
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
        'period',
        'bank_gateway_id'
    ];

    protected $casts = [
        'period' => PlanPeriodEnum::class
    ];

    public static function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'description' => 'string',
            'price' => 'required|decimal:6,2',
            'trial_days' => 'integer',
            'period' => ['required', ValidationRule::enum(PlanPeriodEnum::class)],
            'bank_gateway_id' => 'string|max:60'
        ];
    }
}
