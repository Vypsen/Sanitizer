<?php

require_once __DIR__ . '/vendor/autoload.php';
use Vypsen\Sanitizer\Sanitizer;

$data = '{"foo": "123", "bar": "123.1", "baz": "8 (950) 288-56-23", "arr": ["1","2",3]}';

$filters = [
    "foo" => 'int',
    "bar" => 'inter',
    "baz" => 'ru_number_phone',
];

$sanitizer = Sanitizer::applySanitizers($data, $filters);
var_dump($sanitizer);


