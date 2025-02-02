<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'festival',
        'missed_conn',
        'post',
        'mc_image',
        'created_at',
        'updated_at',
        '_token',
        '_method'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Comments()
    {
        return $this->hasMany(comments::class, 'post_id', 'id');
    }
}
