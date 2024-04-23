<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetToken extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'user_id'
    ];

    protected $casts = [];

    public static function rules(): array {
        return [
            'email' => 'required|email|max:255|unique:password_reset_tokens',
            'user_id' => 'required|int'
        ];
    }
}
