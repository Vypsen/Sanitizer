<?php

namespace Vypsen\Sanitizer\Tests\CustomFilters;

use Vypsen\Sanitizer\Interfaces\Filter;

class CapitalLetterFilter implements Filter
{
    public function sanitize($value, $option): string
    {
        return ucfirst($value);
    }

    public function validation($value): bool
    {
        return is_string($value);
    }

    public function errorMessageValid(): string
    {
        return 'value must be a string';
    }
}