<?php

namespace Vypsen\Sanitizer\Interfaces;

interface Filter
{
    public function sanitize($value);
    public function validation($value);
    public function errorMessageValid();
}