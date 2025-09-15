<?php

namespace App\Rules;
use Illuminate\Support\Facades\Hash;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldPassword implements ValidationRule
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
        return Hash::check($value,auth()->user()->password);
    }

    public function message()
    {
        return 'Current password must match with old password';
    }
}
