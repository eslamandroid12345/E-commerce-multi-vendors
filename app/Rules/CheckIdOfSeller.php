<?php

namespace App\Rules;

use App\Models\Admin;
use Closure;
use Illuminate\Contracts\Validation\Rule;

class CheckIdOfSeller implements Rule
{
    public function passes($attribute, $value): bool
    {
        return Admin::query()
        ->where('id', $value)
            ->where('user_type','=','seller')
            ->exists();
    }

    public function message(): string
    {
        return 'The selected seller is invalid or does not meet the condition.';
    }
}
