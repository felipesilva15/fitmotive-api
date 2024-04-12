<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'cpf_cnpj',
        'birth_date',
        'bank_gateway_id',
        'inactive'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $with = [
        'phones',
        'adresses'
    ];

    public function phones () {
        return $this->hasMany(Phone::class);
    }

    public function adresses () {
        return $this->hasMany(Address::class);
    }

    public static function rules(): Array {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:3',
            'cpf_cnpj' => 'required|string|unique:users|min:11|max:14',
            'birth_date' => 'required|date',
            'bank_gateway_id' => 'string|max:60',
            'inactive' => 'boolean'
        ];
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
}
