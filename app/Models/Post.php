<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title','content','author_id']; // mass assignable attributes (can use create() method)
    protected $guarded = []; // mass NOT assignable attributes (if guarded is empty, all attributes are mass assignable)

    // relationship method (one post belongs to one user)
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
