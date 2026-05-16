<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Comment extends Model
{
    protected $fillable = ['body', 'post_id'];

    // relationship: comment belongs to a post
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    // polymorphic relationship (one comment has many likes)
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
