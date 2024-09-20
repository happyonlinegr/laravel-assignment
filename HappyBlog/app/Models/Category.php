<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    public function posts(): BelongsToMany{
        return $this->belongsToMany(Post::class);
    }

    public function parent(): BelongsTo{
        return $this->belongsTo(Category::class,'parent_id');
    }

    public function children(): HasMany{
        return $this->hasMany(Category::class,'parent_id');
    }
}
