<?php

namespace App\Models;

use App\Enums\PlanBillingIntervalEnum;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule as ValidationRule;

class Phone extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country',
        'ddd',
        'number',
        'type',
        'main'
    ];

    protected $casts = [
        'type' => PhoneTypeEnum::class
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function rules(): array {
        return [
            'user_id' => 'required|int|max:255',
            'country' => 'required|string|max:2',
            'ddd' => 'required|string|max:3',
            'number' => 'required|string|max:9',
            'type' => ['required', ValidationRule::enum(PhoneTypeEnum::class)],
            'main' => 'boolean'
        ];
    }
}
