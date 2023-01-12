<?php


namespace Vypsen\Sanitizer\Filters;

use Vypsen\Sanitizer\Interfaces\Filter;

class FloatFilter implements Filter
{
    public function sanitize($value, $option = null): float
    {
        return (float) $value;
    }

    public function validation($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT);
    }

    public function errorMessageValid(): string
    {
        return "Float is not valid";
    }
}

