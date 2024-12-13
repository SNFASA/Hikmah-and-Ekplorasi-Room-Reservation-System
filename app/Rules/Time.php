<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Time implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
    }
    public function passes($attribute, $value)
    {
        return preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $value);
    }

    public function message()
    {
        return 'The :attribute must be a valid time in HH:MM format.';
    }
}
