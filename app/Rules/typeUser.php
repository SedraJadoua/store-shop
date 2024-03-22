<?php

namespace App\Rules;

use App\Models\account;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class typeUser implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
    }
}
