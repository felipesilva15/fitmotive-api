<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;
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
        'inactive' => 'boolean'
    ];

    protected $with = [
        'phones',
        'adresses',
        'payment_methods',
        'provider'
    ];

    public function phones(): HasMany {
        return $this->hasMany(Phone::class);
    }

    public function phone(): HasOne {
        return $this->phones()->one()->ofMany('main');
    }

    public function adresses(): HasMany {
        return $this->hasMany(Address::class);
    }

    public function address(): HasOne {
        return $this->adresses()->one()->ofMany('main');
    }

    public function payment_methods(): HasMany {
        return $this->hasMany(PaymentMethod::class);
    }

    public function payment_method(): HasOne {
        return $this->payment_methods()->one()->ofMany('main');
    }

    public function provider(): HasOne {
        return $this->hasOne(Provider::class);
    } 

    public static function rules(User $user = null): array {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(isset($user->id) ? $user->id : 0)],
            'password' => 'required|string|min:3',
            'cpf_cnpj' => ['required', 'string', 'min:11','max:14', Rule::unique('users')->ignore(isset($user->id) ? $user->id : 0)],
            'birth_date' => 'required|date',
            'bank_gateway_id' => 'string|max:60',
            'inactive' => 'boolean'
        ];
    }

    public function getJWTIdentifier(): mixed {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array {
        return [];
    }
}
