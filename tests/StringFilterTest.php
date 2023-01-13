<?php

use PHPUnit\Framework\TestCase;
use Vypsen\Sanitizer\Filters\StringFilter;
use Vypsen\Sanitizer\Sanitizer;

class StringFilterTest extends TestCase
{
    protected $stringFilter;
    protected $sanitizer;
    protected function setUp(): void
    {
        $this->stringFilter = new StringFilter();
        $this->sanitizer = new Sanitizer();
    }

    public function testValidationFail()
    {
        $value = ['1234'];
        $this->assertSame(false, $this->stringFilter->validation($value));
    }

    public function testValidationSuccess()
    {
        $valueStr = '123';
        $this->assertSame(true, $this->stringFilter->validation($valueStr));

        $valueInt = 123.0;
        $this->assertSame(true, $this->stringFilter->validation($valueInt));
    }

    public function testSanitizerErrorMessage()
    {
        $expected = ['value' => $this->stringFilter->errorMessageValid()];

        $data = '{"value": ["1234"]}';
        $filter = ["value" => 'string'];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerSuccess()
    {
        $expected = ['value' => '123'];

        $data1 = '{"value": "123"}';
        $filter1 = ['value' => 'string'];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data1, $filter1));

        $data2 = '{"value": 123}';
        $filter2 = ['value' => 'string'];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data2, $filter2));
    }
}