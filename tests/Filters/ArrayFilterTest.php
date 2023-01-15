<?php


namespace Filters;

use PHPUnit\Framework\TestCase;
use Vypsen\Sanitizer\Filters\ArrayFilter;
use Vypsen\Sanitizer\Sanitizer;

class ArrayFilterTest extends TestCase
{
    protected $arrayFilter;
    protected $sanitizer;
    protected $filterName;

    protected function setUp(): void
    {
        $this->arrayFilter = new ArrayFilter();
        $this->sanitizer = new Sanitizer();
        $this->filterName = 'array';
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
        $filter = ["value" => [$this->filterName, 'int']];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerSuccessWithInt()
    {
        $expectedInt = ["arr" => [1, 2, 3]];
        $data = '{"arr": ["1", "2", 3]}';
        $filter = ['arr' => [$this->filterName, 'int']];
        $this->assertSame($expectedInt, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerSuccessWithStr()
    {
        $expectedStr = ["arr" => ['1', '2', '3']];
        $data = '{"arr": ["1","2",3]}';
        $filter = ["arr" => [$this->filterName, 'string']];
        $this->assertSame($expectedStr, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerSuccessWithBool()
    {
        $expectedStr = ["arr" => [true, true, true]];
        $data = '{"arr": ["1","2",3]}';
        $filter = ["arr" => [$this->filterName, 'bool']];
        $this->assertSame($expectedStr, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerSuccessWithUndefined()
    {
        $expectedStr = ["arr" => ['undefined option']];
        $data = '{"arr": ["1","2",3]}';
        $filter = ["arr" => [$this->filterName, 'qwerty']];
        $this->assertSame($expectedStr, $this->sanitizer::applySanitizers($data, $filter));
    }
}