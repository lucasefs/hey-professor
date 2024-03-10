<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

use function strlen;

class QuestionEndsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value[strlen($value) - 1] != '?') {
            $fail('Are you sure that is a question? It is missing the question mark in the end.');

        }
    }
}
