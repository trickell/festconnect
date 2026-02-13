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
        'email',
        'password',
        'role',
        'profile_image',
        'about_me',
        'festivals',
        'genres',
        'last_seen_at',
        'penalty_marks',
        'banned_until',
        'google_id',
        'google_token',
        'google_refresh_token',
        'facebook_id',
        'has_seen_welcome'
    ];

    /**
     * The attributes that should be hidden for serialization.
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
        'password' => 'hashed',
        'genres' => 'array',
        'last_seen_at' => 'datetime',
        'banned_until' => 'datetime',
        'has_seen_welcome' => 'boolean',
    ];

    public function posts()
    {
        return $this->hasMany(Posts::class, 'user_id', 'id');
    }

    public function generatedInvites()
    {
        return $this->hasMany(BetaInvite::class, 'user_id');
    }

}
