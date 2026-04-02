<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Enum;

use Imponeer\Properties\DeprecatedTypes;
use Imponeer\Properties\Enum\DataType;
use Imponeer\Properties\Types;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class DataTypeTest extends TestCase
{
    #[DataProvider('typeClassProvider')]
    public function testTypeClassMapping(DataType $case, string $expectedClass): void
    {
        $this->assertSame($expectedClass, $case->getTypeClass());
        // ensure cached mapping returns consistent result
        $this->assertSame($expectedClass, $case->getTypeClass());
    }

    public static function typeClassProvider(): iterable
    {
        yield [DataType::STRING, Types\StringType::class];
        yield [DataType::INTEGER, Types\IntegerType::class];
        yield [DataType::FLOAT, Types\FloatType::class];
        yield [DataType::BOOLEAN, Types\BooleanType::class];
        yield [DataType::FILE, Types\FileType::class];
        yield [DataType::DATETIME, Types\DateTimeType::class];
        yield [DataType::ARRAY, Types\ArrayType::class];
        yield [DataType::LIST, Types\ListType::class];
        yield [DataType::OBJECT, Types\ObjectType::class];
        yield [DataType::OTHER, Types\OtherType::class];
        yield [DataType::DEP_FILE, DeprecatedTypes\FileType::class];
        yield [DataType::DEP_TXTBOX, DeprecatedTypes\TxtboxType::class];
        yield [DataType::DEP_URL, DeprecatedTypes\UrlType::class];
        yield [DataType::DEP_EMAIL, DeprecatedTypes\EmailType::class];
        yield [DataType::DEP_SOURCE, DeprecatedTypes\SourceType::class];
        yield [DataType::DEP_STIME, DeprecatedTypes\StimeType::class];
        yield [DataType::DEP_MTIME, DeprecatedTypes\MtimeType::class];
        yield [DataType::DEP_CURRENCY, DeprecatedTypes\CurrencyType::class];
        yield [DataType::DEP_TIME_ONLY, DeprecatedTypes\TimeOnlyType::class];
        yield [DataType::DEP_URLLINK, DeprecatedTypes\UrllinkType::class];
        yield [DataType::DEP_IMAGE, DeprecatedTypes\ImageType::class];
        yield [DataType::DEP_FORM_SECTION, DeprecatedTypes\FormSectionType::class];
        yield [DataType::DEP_FORM_SECTION_CLOSE, DeprecatedTypes\FormSectionCloseType::class];
    }
}
