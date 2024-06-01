<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Exercice extends Model
{
    use HasFactory;

    protected $fillable = [
        'workout_id',
        'name',
        'series',
        'repetitions',
        'description'
    ];

    public function workout(): BelongsTo {
        return $this->belongsTo(Workout::class);
    }

    public static function label(): string {
        return 'exercício';
    }

    public static function rules(): array {
        return [
            'workout_id' => 'required|int',
            'name' => 'required|string|max:40',
            'series' => 'required|int',
            'repetitions' => 'required|int',
            'description' => 'nullable|string'
        ];
    }
}
