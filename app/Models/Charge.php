<?php

namespace App\Models;

use App\Enums\PaymentMethodTypeEnum;
use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\Rule;

class Charge extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'patient_id',
        'financial_transaction_id',
        'bank_gateway_id',
        'description',
        'payment_method',
        'due_date',
        'amount',
        'payment_status',
        'paid_at'
    ];

    protected $cast = [
        'payment_method' => PaymentMethodTypeEnum::class,
        'due_date' => 'date',
        'payment_status' => PaymentStatusEnum::class,
        'paid_at' => 'date',
    ];

    public function provider(): BelongsTo {
        return $this->belongsTo(Provider::class);
    } 

    public function patient(): BelongsTo {
        return $this->belongsTo(Patient::class);
    }

    public function financial_transaction(): HasOne {
        return $this->hasOne(FinancialTransaction::class);
    }

    public function charge_links(): HasMany {
        return $this->hasMany(ChargeLink::class);
    }

    public static function label(): string {
        return 'cobrança';
    }

    public static function rules(): array {
        return [
            'provider_id' => 'required|int',
            'patient_id' => 'required|int',
            'financial_transaction_id' => 'nullable|int',
            'bank_gateway_id' => 'nullable|string|max:60',
            'description' => 'nullable|string',
            'payment_method' => ['required', Rule::enum(PaymentMethodTypeEnum::class)],
            'due_date' => 'required|date',
            'amount' => 'required|decimal:0,2',
            'payment_status' => ['required', Rule::enum(PaymentStatusEnum::class)],
            'paid_at' => 'nullable|date'
        ];
    }
}
