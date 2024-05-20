<?php

namespace App\Models;

use App\Enums\MovementTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Validation\Rule;

class FinancialTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'movement_type',
        'amount',
        'transaction_date'
    ];

    protected $cast = [
        'transaction_date' => 'date',
        'movement_type' => MovementTypeEnum::class
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function charge(): HasOne {
        return $this->hasOne(Charge::class);
    }

    public static function label(): string {
        return 'transação financeira';
    }

    public static function rules(): array {
        return [
            'user_id' => 'required|int',
            'description' => 'required|string',
            'movement_type' => ['required', Rule::enum(MovementTypeEnum::class)],
            'amount' => 'required|decimal:0,2',
            'transaction_date' => 'date'
        ];
    }
}
