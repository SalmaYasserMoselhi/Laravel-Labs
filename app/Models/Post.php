<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes, Sluggable;
    protected $fillable = ['title','content','author_id','image']; // mass assignable attributes (can use create() method)
    protected $guarded = []; // mass NOT assignable attributes (if guarded is empty, all attributes are mass assignable)

    /**
     * Return the sluggable configuration array for this model.
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true,
            ]
        ];
    }

    // relationship method (one post belongs to one user)
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // relationship method (one post has many comments)
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // polymorphic relationship (one post has many likes)
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
