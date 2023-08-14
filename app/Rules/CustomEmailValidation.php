<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomEmailValidation implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $domainPart = explode('@', $value)[1] ?? null;
        if (!$domainPart) {
            return false;
        }

        if ($domainPart != 'tup.edu.ph') {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a @tup.edu.ph address.';
    }
}
