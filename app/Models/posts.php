<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'festival',
        'missed_conn',
        'post',
        'mc_image',
        'post_type',
        'category',
        'images'
    ];

    protected $casts = [
        'images' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id', 'id');
    }
}
