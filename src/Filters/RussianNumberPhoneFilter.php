<?php

namespace Vypsen\Sanitizer\Filters;

use Vypsen\Sanitizer\Interfaces\Filter;


class RussianNumberPhoneFilter implements Filter
{
    private $form = '/^((8|\+7)[\- ]?)?(\(?\d{3,4}\)?[\- ]?)?[\d\- ]{7,10}$/';

    public function sanitize($value, $option = null): string
    {
        $value = preg_replace('/\D+/', '', $value);
        return '7' . substr($value, 1);
    }

    public function validation($value): bool
    {
        return preg_match($this->form, $value);
    }

    public function errorMessageValid(): string
    {
        return 'number phone is not valid';
    }
}