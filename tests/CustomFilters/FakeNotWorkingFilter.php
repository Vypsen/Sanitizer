<?php

namespace CustomFilters;

class FakeNotWorkingFilter
{
    public function sanitize($value, $option): string
    {
        return strtoupper($value);
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