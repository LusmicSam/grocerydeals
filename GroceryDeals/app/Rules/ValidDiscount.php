<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidDiscount implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check that discount percentage is not more than 90%
        if (!is_numeric($value) || $value > 90) {
            $fail('The :attribute cannot be more than 90%.');
        }
    }
}
