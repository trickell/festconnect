<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BetaInvite extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'email',
        'sent_at',
        'activated_at',
        'is_active',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'activated_at' => 'datetime',
        'is_active' => 'boolean',
    ];
}
