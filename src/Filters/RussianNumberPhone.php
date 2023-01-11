<?php

namespace Vypsen\Sanitizer\Filters;

use Vypsen\Sanitizer\Interfaces\Filter;


class RussianNumberPhone implements Filter
{
    private $form = '/^((8|\+7)[\- ]?)?(\(?\d{3,4}\)?[\- ]?)?[\d\- ]{7,10}$/';

    public function sanitize($value)
    {
        $value = preg_replace('/\D+/', '', $value);
        return '7' . substr($value, 1);
    }

    public function validation($value)
    {
        return preg_match($this->form, $value);
    }

    public function errorMessageValid()
    {
        return 'number phone is not valid';
    }
}