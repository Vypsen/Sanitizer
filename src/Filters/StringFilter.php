<?php

namespace Vypsen\Sanitizer\Filters;

use Vypsen\Sanitizer\Interfaces\Filter;

class StringFilter implements Filter
{
    public function sanitize($value, $option = null)
    {
        if (empty($value)) {
            return null;
        }
        return (string) $value;
    }

    public function validation($value): bool
    {
        return is_string($value) || is_int($value) || is_float($value);
    }

    public function errorMessageValid(): string
    {
        return "String is not valid";
    }
}