<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Comment extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'content',
        'post_id',
        'user_id',
    ];

    public function post():HasOne{
        return $this->hasOne(Post::class,'id','post_id');
    }

    public function user():HasOne{
        return $this->hasOne(User::class,'id','user_id');
    }

    public function scopeAuthor($query,$userid = null):Builder{
        return $userid?$query->where('user_id',$userid)->with('user'):$query;
    }

    public function scopeauthorPost($query,$userid = null):Builder{
        return $userid?$query->where('user_id',$userid)->with('post'):$query;
    }
}
