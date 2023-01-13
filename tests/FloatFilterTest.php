<?php

use PHPUnit\Framework\TestCase;
use Vypsen\Sanitizer\Filters\FloatFilter;
use Vypsen\Sanitizer\Sanitizer;

class FloatFilterTest extends TestCase
{
    protected $floatFilter;
    protected $sanitizer;
    protected function setUp(): void
    {
        $this->floatFilter = new FloatFilter();
        $this->sanitizer = new Sanitizer();
    }

    public function testValidationFail()
    {
        $value = '123abc';
        $this->assertSame(false, $this->floatFilter->validation($value));
    }

    public function testValidationSuccess()
    {
        $valueStr = '123';
        $this->assertSame(true, $this->floatFilter->validation($valueStr));

        $valueInt = 123.0;
        $this->assertSame(true, $this->floatFilter->validation($valueInt));
    }

    public function testSanitizerErrorMessage()
    {
        $expected = ['value' => $this->floatFilter->errorMessageValid()];

        $data = '{"value": "123abc"}';
        $filter = ['value' => 'float'];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerSuccess()
    {
        $expected = ['value' => 123.0];

        $data1 = '{"value": "123"}';
        $filter1 = ['value' => 'float'];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data1, $filter1));

        $data2 = '{"value": 123}';
        $filter2 = ['value' => 'float'];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data2, $filter2));
    }
}