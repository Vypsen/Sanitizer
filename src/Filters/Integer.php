<?php

namespace Vypsen\Sanitizer\Filters;

use Vypsen\Sanitizer\Interfaces\Filter;

class Integer implements Filter
{
    public function sanitize($int)
    {
        $valid = filter_var($int, FILTER_VALIDATE_INT);
        if ($valid === false) {
            return "Integer is not valid";
        }
        return $valid;
    }

    public function validation($value)
    {
        // TODO: Implement validation() method.
    }

    public function errorMessageValid()
    {
        // TODO: Implement errorMessageValid() method.
    }
}