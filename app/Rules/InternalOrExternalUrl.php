<?php

declare(strict_types=1);

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InternalOrExternalUrl implements Rule
{
    public function passes($attribute, $value): bool
    {
        if ($value === null || $value === '') {
            return true;
        }

        if (str_starts_with($value, '#')) {
            return true;
        }

        if (str_starts_with($value, '/')) {
            return filter_var('http://example.com'.$value, FILTER_VALIDATE_URL) !== false;
        }

        if (filter_var($value, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        return in_array(parse_url($value, PHP_URL_SCHEME), ['http', 'https'], true);
    }

    public function message(): string
    {
        return 'Atribut :attribute harus berupa anchor, URL internal, atau URL eksternal yang valid.';
    }
}
