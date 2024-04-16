<?php

namespace App\Models;

use App\Enums\BillingRecurrenceEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\Rule;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider_id',
        'service_price',
        'billing_recurrence'
    ];

    protected $casts = [
        'billing_recurrence' => BillingRecurrenceEnum::class
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function provider(): BelongsTo {
        return $this->belongsTo(Provider::class);
    }

    public static function rules(): array {
        return [
            'user_id' => 'required|int',
            'provider_id' => 'required|int',
            'service_price' => 'required|decimal:0,2',
            'billing_recurrence' => ['required', Rule::enum(BillingRecurrenceEnum::class)]
        ];
    }
}
