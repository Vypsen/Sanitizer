<?php


use PHPUnit\Framework\TestCase;
use Vypsen\Sanitizer\Filters\ArrayFilter;
use Vypsen\Sanitizer\Sanitizer;

class ArrayFilterTest extends TestCase
{
    protected $arrayFilter;
    protected $sanitizer;
    protected function setUp(): void
    {
        $this->arrayFilter = new ArrayFilter();
        $this->sanitizer = new Sanitizer();
    }

    public function testValidationFail()
    {
        $value = '123456';
        $this->assertSame(false, $this->arrayFilter->validation($value));
    }

    public function testValidationSuccess()
    {
        $value = ['1', '2', '3'];
        $this->assertSame(true, $this->arrayFilter->validation($value));
    }

    public function testSanitizerErrorMessage()
    {
        $expected = ['value' => $this->arrayFilter->errorMessageValid()];

        $data = '{"value": "123456"}';
        $filter = ["value" => ['array', 'int']];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerSuccessWithInt()
    {
        $expectedInt = ["arr" => [1, 2, 3]];
        $data = '{"arr": ["1","2",3]}';
        $filter = ['arr' => ['array', 'int']];
        $this->assertSame($expectedInt, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerSuccessWithStr()
    {
        $expectedStr = ["arr" => ['1', '2', '3']];
        $data = '{"arr": ["1","2",3]}';
        $filter = ["arr" => ['array', 'string']];
        $this->assertSame($expectedStr, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerSuccessWithBool()
    {
        $expectedStr = ["arr" => [true, true, true]];
        $data = '{"arr": ["1","2",3]}';
        $filter = ["arr" => ['array', 'bool']];
        $this->assertSame($expectedStr, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerSuccessWithUndefined()
    {
        $expectedStr = ["arr" => ['undefined option']];
        $data = '{"arr": ["1","2",3]}';
        $filter = ["arr" => ['array', 'qwerty']];
        $this->assertSame($expectedStr, $this->sanitizer::applySanitizers($data, $filter));
    }
}