<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'name',
        'description'
    ];

    public function exercices(): HasMany {
        return $this->hasMany(Exercice::class);
    }

    public static function label(): string {
        return 'treino';
    }

    public static function rules(): array {
        return [
            'provider_id' => 'required|int',
            'name' => 'required|string|max:40',
            'description' => 'nullable|string'
        ];
    }
}
