<?php

namespace App\Rules;

use App\Constants\LoanConstant;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LoanDueDate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $now = Carbon::now();
        $diff = $now->diffInDays($value, false);

        if ($diff <= 0) {
            $fail('The :attribute must not be lower or same date.');
        }

        if ($diff > LoanConstant::MAX_LOAN_DATE) {
            $message = 'The :attribute must not be greater than ' . LoanConstant::MAX_LOAN_DATE . ' days';
            $fail($message);
        }
    }
}
