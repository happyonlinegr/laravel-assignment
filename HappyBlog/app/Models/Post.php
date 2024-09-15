<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    public function tags(): HasMany{
        return $this->hasMany(Tag::class);
    }

    public function categoreies(): BelongsToMany{
        return $this->belongsToMany(Category::class,'post_category');
    }

    public function comments():HasMany{
        return $this->hasMany(Comment::class);
    }
}
