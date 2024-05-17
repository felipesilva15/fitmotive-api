<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\LogActionEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Validation\Rule;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'action'
    ];

    protected $cast = [
        'action' => LogActionEnum::class
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    } 

    public static function rules(): array {
        return [
            'user_id' => 'required|int',
            'description' => 'required|string|max:254',
            'action' => ['required', Rule::enum(LogActionEnum::class)],
        ];
    }
}
