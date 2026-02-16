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
        'queued_at',
        'activated_at',
        'is_active',
        'user_id',
        'used_by_user_id',
    ];

    public function generator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'used_by_user_id');
    }

    protected $casts = [
        'sent_at' => 'datetime',
        'queued_at' => 'datetime',
        'activated_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function isInQueue()
    {
        return $this->queued_at && $this->queued_at->isAfter(now()->subDay()) && !$this->is_active;
    }

    public function isAvailable()
    {
        return !$this->is_active && !$this->isInQueue();
    }
}
