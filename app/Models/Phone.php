<?php

namespace App\Models;

use App\Enums\PhoneTypeEnum;
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
        'type' => PhoneTypeEnum::class,
        'main' => 'boolean'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function label(): string {
        return 'telefone';
    }

    public static function rules(): array {
        return [
            'user_id' => 'required|int',
            'country' => 'required|string|max:2',
            'ddd' => 'required|string|max:3',
            'number' => 'required|string|max:9',
            'type' => ['required', ValidationRule::enum(PhoneTypeEnum::class)],
            'main' => 'boolean'
        ];
    }
}
