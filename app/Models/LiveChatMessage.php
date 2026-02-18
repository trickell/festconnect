<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'stream_id',
        'user_id',
        'message',
        'color_override'
    ];

    public function stream()
    {
        return $this->belongsTo(LiveStream::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
