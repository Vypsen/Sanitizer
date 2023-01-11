<?php

require_once __DIR__ . '/vendor/autoload.php';
use Vypsen\Sanitizer\Sanitizer;

$t = '121й3';
$data = '{"foo": "123", "bar": "asd", "baz": "8 (950) 288-56-23"}';

$filters = [
    "foo" => \Vypsen\Sanitizer\Filters\Integer::class,
    "bar" => \Vypsen\Sanitizer\Filters\Stringq::class,
    "baz" => \Vypsen\Sanitizer\Filters\RussianNumberPhone::class,
];

$sanitizer = Sanitizer::applySanitizers($data, $filters);
