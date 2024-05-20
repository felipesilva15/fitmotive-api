<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\Rule;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'plan_id',
        'bank_gateway_id',
        'amount',
        'pro_rata',
        'payment_status',
        'inactive'
    ];

    public function plan(): BelongsTo {
        return $this->belongsTo(Plan::class);
    }

    public function provider(): BelongsTo {
        return $this->belongsTo(Provider::class);
    }

    public static function label(): string {
        return 'assinatura';
    }

    public static function rules(): array {
        return [
            'provider_id' => 'required|int',
            'plan_id' => 'required|int',
            'bank_gateway_id' => 'string|max:60',
            'amount' => 'required|decimal:0,2',
            'pro_rata' => 'boolean',
            'payment_status' => ['required', Rule::enum(PaymentStatusEnum::class)],
            'inactive' => 'boolean',
        ];
    }
}
