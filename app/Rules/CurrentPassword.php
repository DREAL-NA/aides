<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class CurrentPassword implements Rule
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
     * @param  string $attribute
     * @param  mixed $value
     * @param array $parameters
     * @return bool
     */
    public function passes($attribute, $value, $parameters = [])
    {
        if (empty($parameters[0])) {
            $user = auth()->user();
        } else {
            $user = User::find($parameters[0]);
        }

        return $user && Hash::check($value, $user->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le champ :attribute est invalide.';
    }
}
