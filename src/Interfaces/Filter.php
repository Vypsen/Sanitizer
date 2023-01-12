<?php

namespace Vypsen\Sanitizer\Interfaces;

interface Filter
{
    public function sanitize($value, $option);
    public function validation($value): bool;
    public function errorMessageValid(): string;
}