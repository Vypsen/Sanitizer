<?php

use PHPUnit\Framework\TestCase;
use Vypsen\Sanitizer\Filters\IntegerFilter;
use Vypsen\Sanitizer\Sanitizer;

class IntFilterTest extends TestCase
{
    protected $intFilter;
    protected $sanitizer;
    protected function setUp(): void
    {
        $this->intFilter = new IntegerFilter();
        $this->sanitizer = new Sanitizer();
    }

    public function testValidationFail()
    {
        $value = '123abc';
        $this->assertSame(false, $this->intFilter->validation($value));
    }

    public function testValidationSuccess()
    {
        $valueStr = '123';
        $this->assertSame(true, $this->intFilter->validation($valueStr));

        $valueInt = 123;
        $this->assertSame(true, $this->intFilter->validation($valueInt));
    }

    public function testSanitizerErrorMessage()
    {
        $expected = ['value' => $this->intFilter->errorMessageValid()];

        $data = '{"value": "123abc"}';
        $filter = ['value' => 'int'];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerSuccess()
    {
        $expected = ['value' => 123];

        $data1 = '{"value": "123"}';
        $filter1 = ['value' => 'int'];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data1, $filter1));

        $data2 = '{"value": 123}';
        $filter2 = ['value' => 'int'];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data2, $filter2));
    }
}