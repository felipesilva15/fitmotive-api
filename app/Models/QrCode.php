<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'charge_id',
        'bank_gateway_id',
        'image_uri',
        'text',
        'amount',
        'expiration_date'
    ];

    public static function label(): string {
        return 'Qr Code';
    }

    public static function rules(): array {
        return [
            'charge_id' => 'required|int',
            'image_uri' => 'required|string|max:512',
            'text' => 'required|string|max:1024',
            'amount' => 'required|decimal:0,2',
            'expiration_date' => 'required|date',
            'bank_gateway_id' => 'nullable|string|max:60'
        ];
    }
}
