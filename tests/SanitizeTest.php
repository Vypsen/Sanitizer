<?php

use PHPUnit\Framework\TestCase;
use Vypsen\Sanitizer\Sanitizer;

class SanitizeTest extends TestCase
{
    protected $sanitizer;

    protected function setUp(): void
    {
        $this->sanitizer = new Sanitizer();
    }

    public function testDefaultFilters()
    {
        $data = '{"foo": "123", "bar": "asd", "baz": "8 (950) 288-56-23"}';
        $filters = [
            "foo" => 'int',
            "bar" => 'string',
            "baz" => 'ru_number_phone'
        ];

        $expected = [
            "foo" => 123,
            "bar" => "asd",
            "baz" => "79502885623"
        ];

        $this->assertSame($expected, $this->sanitizer::applySanitizers($data, $filters));
    }

    public function testDefaultAndCustomFilters()
    {
        $data = '{"foo": "123", "bar": "asd", "baz": "8 (950) 288-56-23"}';
        $filters = [
            "foo" => 'int',
            "bar" => \CustomFilters\CapitalLetterFilter::class,
            "baz" => 'ru_number_phone'
        ];

        $expected = [
            "foo" => 123,
            "bar" => "Asd",
            "baz" => "79502885623"
        ];

        $this->assertSame($expected, $this->sanitizer::applySanitizers($data, $filters));
    }

    public function testDefaultAndFakeFilters()
    {
        $data = '{"foo": "qwerty", "bar": "asd", "baz": "8 (950) 288-56-23"}';
        $filters = [
            "foo" => \CustomFilters\FakeNotWorkingFilter::class,
            "bar" => \CustomFilters\CapitalLetterFilter::class,
            "baz" => 'ru_number_phone'
        ];

        $this->expectException(\Exception::class);
        $this->sanitizer::applySanitizers($data, $filters);
    }

    public function testDefaultAndFakeFilters2()
    {
        $data = '{"foo": ["1", 2, "3"], "bar": "asd", "baz": "8 (950) 288-56-23"}';
        $filters = [
            "foo" => ['array', 'int'],
            "bar" => \CustomFilters\CapitalLetterFilter::class,
            "baz" => 'FakeFilter'
        ];

        $expected = [
            "foo" => [1, 2, 3],
            "bar" => "Asd",
            "baz" => "filter class not found"
        ];

        $this->assertSame($expected, $this->sanitizer::applySanitizers($data, $filters));
    }
}