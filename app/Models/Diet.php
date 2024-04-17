<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Diet extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'name',
        'description'
    ];

    public function provider(): BelongsTo {
        return $this->belongsTo(Provider::class);
    }

    public static function rules(): array {
        return [
            'provider_id' => 'required|int',
            'name' => 'required|string|max:40',
            'description' => 'required'
        ];
    }
}
