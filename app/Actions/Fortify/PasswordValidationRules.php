<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        $rule = (new Password())
                    ->requireNumeric()
                    ->length(6);

        return ['required', 'string', $rule, 'max:12', 'confirmed'];
    }
}
