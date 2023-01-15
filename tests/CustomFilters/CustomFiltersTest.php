<?php

namespace Vypsen\Sanitizer\Tests\CustomFilters;

require_once('CapitalLetterFilter.php');
require_once('FakeNotWorkingFilter.php');

use PHPUnit\Framework\TestCase;
use Vypsen\Sanitizer\Sanitizer;

class CustomFiltersTest extends TestCase
{
    protected $capitalLetterFilter;
    protected $sanitizer;

    protected function setUp(): void
    {
        $this->capitalLetterFilter = new CapitalLetterFilter();
        $this->sanitizer = new Sanitizer();
    }

    public function testSanitizerSuccess()
    {
        $expected = ['value' => 'Qwerty'];

        $data = '{"value": "qwerty"}';
        $filter = ['value' => CapitalLetterFilter::class];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerErrorMessage()
    {
        $expected = ['value' => $this->capitalLetterFilter->errorMessageValid()];

        $data = '{"value": ["qwe"]}';
        $filter = ["value" => CapitalLetterFilter::class];
        $this->assertSame($expected, $this->sanitizer::applySanitizers($data, $filter));
    }

    public function testSanitizerFakeFilter()
    {
        $data = '{"value": "qwerty"}';
        $filter = ["value" => FakeNotWorkingFilter::class];

        $this->expectException(\Exception::class);
        $this->sanitizer::applySanitizers($data, $filter);
    }
}