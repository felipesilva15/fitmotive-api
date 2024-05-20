<?php

namespace App\Models;

use App\Enums\ChargeLinkReferenceEnum;
use App\Enums\ResponseTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\Rule;

class ChargeLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'charge_id',
        'reference',
        'uri',
        'response_type'
    ];

    protected $cast = [
        'reference' => ChargeLinkReferenceEnum::class,
        'response_type' => ResponseTypeEnum::class
    ];

    public function charge(): BelongsTo {
        return $this->belongsTo(Charge::class);
    }

    public static function label(): string {
        return 'link da cobrança';
    }

    public static function rules(): array {
        return [
            'charge_id' => 'required|int',
            'uri' => 'required|string|max:512',
            'reference' => ['required', Rule::enum(ChargeLinkReferenceEnum::class)],
            'response_type' => ['required', Rule::enum(ResponseTypeEnum::class)]
        ];
    }
}
