<?php

require_once __DIR__ . '/vendor/autoload.php';
use Vypsen\Sanitizer\Sanitizer;
require_once('tests/CustomFilters/CapitalLetterFilter.php');
require_once('tests/CustomFilters/FakeNotWorkingFilter.php');


$data = '{"arr":  "3123"}';
$filters = [
    "arr" => 'structure'
];


$sanitizer = Sanitizer::applySanitizers($data, $filters);
var_dump($sanitizer);
