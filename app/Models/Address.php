<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'adresses';

    protected $fillable = [
        'user_id',
        'name',
        'postal_code',
        'street',
        'locality',
        'city',
        'region',
        'region_code',
        'number',
        'complement',
        'main'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public static function rules(): array {
        return [
            'user_id' => 'required|int',
            'name' => 'required|string|max:40',
            'postal_code' => 'required|string|min:8|max:8',
            'street' => 'required|string|max:80',
            'locality' => 'required|string|max:40',
            'city' => 'required|string|max:60',
            'region' => 'required|string|max:40',
            'region_code' => 'required|string|max:2',
            'number' => 'required|string|max:6',
            'complement' => 'string|max:120',
            'main' => 'boolean'
        ];
    }
}
