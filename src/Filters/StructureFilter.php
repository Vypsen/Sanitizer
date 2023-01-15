<?php

namespace Vypsen\Sanitizer\Filters;

use Vypsen\Sanitizer\Interfaces\Filter;

class StructureFilter implements Filter
{
    public function sanitize($value, $option)
    {
        return (array) $value;
    }

    public function validation($value): bool
    {
        return is_object($value);
    }

    public function errorMessageValid(): string
    {
        return 'value is not a structure';
    }
}