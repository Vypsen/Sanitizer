# Sanitizer


## Installation

``` 
composer require vypsen/sanitizer dev-master
```
## Filters


 filter                   | description
--------------------------|-------------------------
 ['array' '`type`']       | array of the same type of elements (`type`: ['string', 'int', 'float', 'bool'])
 'float'                  | converts in float type
 'int'                    | converts in integer type
 'ru_number_phone'        | checks and normalizes the Russian phone number
 'string'                 | converts in string type
 'structure'              | converts a json object into an associative array

## Example 
``` php
use Vypsen\Sanitizer\Sanitizer;

$jsonData = '{"arr": ["1", 2, "3"], "foo": "123", "bar": 123, "baz": "8 (950) 288-56-23", "qwe": {"123": "qwerty", "abc": 321}}';

$filters = [
    "arr" => ['array', 'int'],
    "foo" => 'int',
    "bar" => 'string',
    "baz" => 'ru_number_phone',
    "qwe" => 'structure'
];

$data = Sanitizer::applySanitizers($jsonData, $filters);
var_dump($data);
```
## Result

``` php
[
    'arr' => [1, 2, 3],
    'foo' => 123,
    'bar' => '123',
    'baz' => '79502885623',
    'qwe' => ['123' => 'qwerty', 'abc' => 321],
];
```
## Tests
### To run tests
``` 
./vendor/bin/phpunit ./vendor/vypsen/sanitizer/tests
```

## Custom filter
For a custom filter, you need to create a class that will implements Vypsen\Sanitizer\Interfaces\Filter
### example 
``` php

use Vypsen\Sanitizer\Interfaces\Filter;

class TestClass implements Filter
{
    public function sanitize($value, $option): string
    {
        return ucfirst($value);
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
```
to apply a filter
``` php
require_once('TestClass.php');

$jsonData = '{"arr": ["1", 2, "3"], "foo": "abs"}';

$filters = [
    "arr" => ['array', 'string'],
    "foo" => TestClass::class,
];

$data = Sanitizer::applySanitizers($jsonData, $filters);
var_dump($data);
```
result
``` php
[
    'arr' => ['1', '2', '3'],
    'foo' => 'Abs'
];
```
