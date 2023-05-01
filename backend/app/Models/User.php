<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nickname',
        'email',
        'password',
        'userType',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        // evento disparado quando um novo usuário é criado
        static::creating(function ($user) {
            // $user->created_by = auth()->id();
        });

        // evento disparado quando um usuário é atualizado
        static::updating(function ($user) {
            // $user->updated_by = auth()->id();
        });

        // evento disparado quando um usuário é criado ou atualizado
        static::saving(function ($user) {
            $user->updated_at = now();
            if (!$user->exists) {
                // $user->created_at = $user->updated_at;
            }
        });
    }
}
