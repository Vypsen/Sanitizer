<?php

use PHPUnit\Framework\TestCase;
use Vypsen\Sanitizer\Filters\RussianNumberPhoneFilter;
use Vypsen\Sanitizer\Sanitizer;

class RussianNumberPhoneFilterTest extends TestCase
{
    protected $ruNumberFilter;
    protected $sanitizer;
    protected function setUp(): void
    {
        $this->ruNumberFilter = new RussianNumberPhoneFilter();
        $this->sanitizer = new Sanitizer();
    }

    public function testValidationFail()
    {
        $value = '123456';
        $this->assertSame(false, $this->ruNumberFilter->validation($value));
    }

    public function testValidationSuccess()
    {
        $value1 = '88005553535';
        $this->assertSame(true, $this->ruNumberFilter->validation($value1));

        $value1 = '8 (950) 288-56-23';
        $this->assertSame(true, $this->ruNumberFilter->validation($value1));
    }

    public function testSanitizerErrorMessage()
    {
        $expected = ['value' => $this->ruNumberFilter->errorMessageValid()];

        $data = '{"value": "123456"}';
        $filter = ["value" => 'ru_number_phone'];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerSuccess()
    {
        $expected1 = ['value' => '79502885623'];
        $data1 = '{"value": "8 (950) 288-56-23"}';
        $filter1 = ['value' => 'ru_number_phone'];

        $this->assertSame($expected1, $this->sanitizer::applySanitizers($data1, $filter1));

        $expected1 = ['value' => '78005553535'];
        $data1 = '{"value": "88005553535"}';
        $filter1 = ['value' => 'ru_number_phone'];
        $this->assertSame($expected1, $this->sanitizer::applySanitizers($data1, $filter1));
    }
}