<?php

namespace App\Rules;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class HasRole implements Rule
{
    /** @var string */
    public $roles;

    /** @var string */
    public $message;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($roles)
    {
        $this->roles = $roles;
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
        $passes = false;

        if (in_array(UserRole::getValues(), $value, true)) {
            $this->message = __('User role not supported');
        }

        /** @var User $user */
        $user = User::find($attribute);
        if ($user->hasAnyRole($value)) {
            $passes = true;
        }

        $this->message = __('User has no '.ucfirst($value).' role');

        return $passes;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
