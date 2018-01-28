<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UrlTextarea implements Rule
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
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = explode(PHP_EOL, $value);
        $isValid = true;
        foreach ($value as $item) {
            if (!preg_match("/\b(?:(?:https?):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$item)) {
                $isValid = false;
                break;
            }
        }

        return $isValid;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attributes doit être une liste d'URLs séparées par des retours à la ligne.";
    }
}
