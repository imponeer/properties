<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Enum;

use Imponeer\Properties\Enum\Format;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class FormatTest extends TestCase
{
    #[DataProvider('formatProvider')]
    public function testFromString(string $input, Format $expected): void
    {
        $this->assertSame($expected, Format::fromString($input));
    }

    public static function formatProvider(): iterable
    {
        yield ['', Format::RAW];
        yield [' ', Format::RAW];
        yield ['s', Format::SHOW];
        yield ['S', Format::SHOW];
        yield ['show', Format::SHOW];
        yield ['p', Format::PREVIEW];
        yield ['Preview', Format::PREVIEW];
        yield ['e', Format::EDIT];
        yield ['edit', Format::EDIT];
        yield ['f', Format::FORM_PREVIEW];
        yield ['form', Format::FORM_PREVIEW];
        yield ['unknown', Format::RAW];
    }
}
