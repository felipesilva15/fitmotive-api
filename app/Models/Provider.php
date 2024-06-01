<?php

namespace App\Models;

use App\Enums\ProviderProfessionEnum;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'plan_id',
        'profession',
        'bank_gateway_id',
        'inactive'
    ];

    protected $casts = [
        'profession' => ProviderProfessionEnum::class,
        'inactive' => 'boolean'
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo {
        return $this->belongsTo(Plan::class);
    }

    public function patients(): HasMany {
        return $this->hasMany(Patient::class);
    }

    public function charges(): HasMany {
        return $this->hasMany(Charge::class);
    }

    public function subscription(): HasOne {
        return $this->hasOne(Subscription::class);
    }

    public function workouts(): HasMany {
        return $this->hasMany(Workout::class);
    }

    public static function label(): string {
        return 'prestador';
    }

    public static function rules(): array {
        return [
            'user_id' => 'required|int',
            'plan_id' => 'required|int',
            'profession' => ['required', ValidationRule::enum(ProviderProfessionEnum::class)],
            'bank_gateway_id' => 'string|max:60',
            'inactive' => 'boolean',
        ];
    }
}
