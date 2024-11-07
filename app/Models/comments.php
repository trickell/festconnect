<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comments extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'parent',
        'comment',   
        'turn_off',     
        'created_at',        
        '_token',
        '_method'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Post()
    {
        return $this->belongsTo(posts::class, 'post_id', 'id');
    }
}
