<?php

namespace Vypsen\Sanitizer\Filters;

use Vypsen\Sanitizer\Interfaces\Filter;

class Integer implements Filter
{
    public function sanitize($value, $option = null): int
    {
        $digit = (int) $value;
        return $digit;
    }

    public function validation($value): bool
    {
        return is_numeric($value);
    }

    public function errorMessageValid(): string
    {
        return "Integer is not valid";
    }
}