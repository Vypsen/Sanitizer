<?php

require_once __DIR__ . '/vendor/autoload.php';
use Vypsen\Sanitizer\Sanitizer;

$data = '{"arr": ["1","2",3]}';

$filters = [
    "arr" => ['array', 'null']
];

$sanitizer = Sanitizer::applySanitizers($data, $filters);
var_dump($sanitizer);


