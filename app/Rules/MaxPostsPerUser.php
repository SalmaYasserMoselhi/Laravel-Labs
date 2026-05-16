<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;
use App\Models\Post;

class MaxPostsPerUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $postsCount = Post::where('author_id', $value)->count();

        if ($postsCount >= 3) {
            $fail('This user already has 3 posts. Each user can only create a maximum of 3 posts.');
        }
    }
}
