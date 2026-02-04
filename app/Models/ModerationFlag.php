<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModerationFlag extends Model
{
    protected $fillable = [
        'moderator_id',
        'target_id',
        'target_type',
        'type',
        'reason',
        'status',
        'admin_comment',
        'admin_id'
    ];

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function post()
    {
        return $this->belongsTo(Posts::class, 'target_id')->where('target_type', 'post');
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'target_id')->where('target_type', 'user');
    }
}
