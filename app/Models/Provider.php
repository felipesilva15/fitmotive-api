<?php

namespace App\Models;

use App\Enums\ProviderProfessionEnum;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function user() {
        return $this->hasOne(User::class);
    }

    public function plan() {
        return $this->hasOne(Plan::class);
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
