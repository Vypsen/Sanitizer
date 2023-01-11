<?php


namespace Vypsen\Sanitizer\Filters;

class Float
{
    public function checkValidation($int)
    {
        $valid = filter_var($int, FILTER_VALIDATE_FLOAT);
        if ($valid === false) {
            return "Float is not valid";
        }
        return $valid;
    }
}

