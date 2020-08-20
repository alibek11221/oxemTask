<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ProductsOrder implements Rule
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
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value === 'cost' || $value === 'created_at';
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Указан неправильный метод сортировки попробуйте значения "cost" или "created_at"';
    }
}
