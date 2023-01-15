<?php

require_once __DIR__ . '/vendor/autoload.php';
use Vypsen\Sanitizer\Sanitizer;
require_once('tests/CustomFilters/CapitalLetterFilter.php');
require_once('tests/CustomFilters/FakeNotWorkingFilter.php');


$data = '{"arr": "qwerty"}';
$filters = [
//    "arr" => \CustomFilters\CapitalLetterFilter::class,
//    "arr" => '1224'
    "arr" => \CustomFilters\FakeNotWorkingFilter::class
];

//echo $filters['arr'];
//
$sanitizer = Sanitizer::applySanitizers($data, $filters);
var_dump($sanitizer);
