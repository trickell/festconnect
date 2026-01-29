<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'images',
        'read_at',
        'deleted_at',
        'is_edited',
    ];

    protected $casts = [
        'images' => 'array',
        'read_at' => 'datetime',
        'deleted_at' => 'datetime',
        'is_edited' => 'boolean',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
