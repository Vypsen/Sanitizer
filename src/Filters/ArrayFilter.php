<?php

namespace Vypsen\Sanitizer\Filters;

use Vypsen\Sanitizer\Interfaces\Filter;

class ArrayFilter implements Filter
{
    public function sanitize($value, $option): array
    {
        switch ($option) {
            case 'string':
                return array_map('strval' ,$value);
            case 'int':
                return array_map('intval', $value);
            case 'float':
                return array_map('floatval', $value);
            case 'null':
                return array_map(null, $value);
            case 'bool':
                return array_map('boolval', $value);
            default:
                return ['undefined option'];
        }
    }

    public function validation($value): bool
    {
        return is_array($value);
    }

    public function errorMessageValid(): string
    {
        return 'value in not array';
    }
}