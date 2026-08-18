<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Portfolio;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class YouTubeVideoUrl implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! is_string($value) || Portfolio::extractYouTubeVideoId($value) === null) {
            $fail('The :attribute must be a valid YouTube video URL.');
        }
    }
}
