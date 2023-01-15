<?php

namespace Filters;

use PHPUnit\Framework\TestCase;
use Vypsen\Sanitizer\Filters\StructureFilter;
use Vypsen\Sanitizer\Sanitizer;

class StructureFilterTest extends TestCase
{
    protected $structureFilter;
    protected $filterName;
    protected $sanitizer;

    protected function setUp(): void
    {
        $this->structureFilter = new StructureFilter();
        $this->sanitizer = new Sanitizer();
        $this->filterName = 'structure';
    }

    public function testValidationSuccess()
    {
        $value = json_decode('{"123": "qwerty", "qwe": "3123"}');
        $this->assertSame(true, $this->structureFilter->validation($value));
    }

    public function testValidationFail()
    {
        $value = json_decode('abc123');
        $this->assertSame(false, $this->structureFilter->validation($value));
    }

    public function testSanitizerErrorMessage()
    {
        $expected = ['value' => $this->structureFilter->errorMessageValid()];

        $data = '{"value": "1234"}';
        $filter = ["value" => $this->filterName];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerSuccess()
    {
        $expected = ['value' => ["123" => "qwerty", "qwe" => "3123"]];

        $data1 = '{"value": {"123": "qwerty", "qwe": "3123"}}';
        $filter1 = ['value' => $this->filterName];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data1, $filter1));

    }
}