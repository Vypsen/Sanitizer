<?php

require_once __DIR__ . '/vendor/autoload.php';
use Vypsen\Sanitizer\Sanitizer;

$data = '{"str": "12qwerty", "foo": "12345", "bar": "123.1", "baz": "8 (950) 288-56-23", "arr": ["1","2",3]}';

$filters = [
    "str" => 'int',
    "foo" => 'ru_number_phone',
    "bar" => 'float',
    "baz" => 'ru_number_phone',
    "arr" => ['array', 'float']

];

$sanitizer = Sanitizer::applySanitizers($data, $filters);
var_dump($sanitizer);


