<?php

namespace Vypsen\Sanitizer\Filters;

use Vypsen\Sanitizer\Interfaces\Filter;

class Stringq implements Filter
{
    public static function checkValidation($str)
    {
        if (!empty($str)) {
            return $str;
        }
        return "Float is not valid";
    }

    public function sanitize($value)
    {
        // TODO: Implement sanitize() method.
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