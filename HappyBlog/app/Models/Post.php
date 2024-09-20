<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'author',
        'slug'
    ];

    public function users(): BelongsTo{
        return $this->belongsTo(User::class,'author');
    }

    public function tags(): BelongsToMany{
        return $this->BelongsToMany(Tag::class,'post_tag');
    }

    public function categories(): BelongsToMany{
        return $this->belongsToMany(Category::class,'post_category');
    }

    public function comments():HasMany{
        return $this->hasMany(Comment::class);
    }

    public function scopeAuthor($query,$userid = null):Builder{
        return $userid?$query->where('author',$userid)->with('users'):$query;
    }

    public function scopeTag($query,$tag = null):Builder{
        return $tag?$query->wherehas('tags',function($subquery) use ($tag){
            $subquery->where('tag_id',$tag);
        })->with('tags'):$query;
    }

    public function scopeCategory($query,$cat_id = null):Builder{
        return $cat_id?$query->wherehas('categories',function($subquery) use ($cat_id){
            $subquery->where('category_id',$cat_id);
        })->with('categories'):$query;
    }

}
