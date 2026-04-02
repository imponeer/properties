<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\DeprecatedTypes;

use Imponeer\Properties\DeprecatedTypes;
use Imponeer\Properties\Enum\ValidationRule;
use Imponeer\Properties\Types;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class DeprecatedTypesTest extends TestCase
{
    #[DataProvider('deprecatedTypeProvider')]
    public function testDeprecatedTypeDefaults(
        string $class,
        string $baseClass,
        array $expectedProperties
    ): void {
        $instance = (new ReflectionClass($class))->newInstanceWithoutConstructor();

        $this->assertInstanceOf($baseClass, $instance);

        foreach ($expectedProperties as $property => $expected) {
            $this->assertSame($expected, $instance->$property);
        }
    }

    public static function deprecatedTypeProvider(): iterable
    {
        yield [
            DeprecatedTypes\CurrencyType::class,
            Types\FloatType::class,
            ['format' => '%d']
        ];

        yield [
            DeprecatedTypes\EmailType::class,
            Types\StringType::class,
            [
                'autoFormatingDisabled' => true,
                'validateRule' => ValidationRule::EMAIL->value
            ]
        ];

        yield [
            DeprecatedTypes\FileType::class,
            Types\IntegerType::class,
            [
                'data_handler' => 'file',
                'autoFormatingDisabled' => true
            ]
        ];

        yield [
            DeprecatedTypes\FormSectionCloseType::class,
            Types\OtherType::class,
            []
        ];

        yield [
            DeprecatedTypes\FormSectionType::class,
            Types\OtherType::class,
            []
        ];

        yield [
            DeprecatedTypes\ImageType::class,
            Types\IntegerType::class,
            [
                'data_handler' => 'image',
                'autoFormatingDisabled' => true,
                'allowedMimeTypes' => [
                    'image/gif',
                    'image/jpeg',
                    'image/pjpeg',
                    'image/png',
                    'image/svg+xml',
                    'image/tiff',
                    'image/vnd.microsoft.icon',
                ]
            ]
        ];

        yield [
            DeprecatedTypes\MtimeType::class,
            Types\DateTimeType::class,
            ['format' => _MEDIUMDATESTRING]
        ];

        yield [
            DeprecatedTypes\SourceType::class,
            Types\StringType::class,
            [
                'sourceFormating' => 'php',
                'autoFormatingDisabled' => true
            ]
        ];

        yield [
            DeprecatedTypes\StimeType::class,
            Types\DateTimeType::class,
            ['format' => _SHORTDATESTRING]
        ];

        yield [
            DeprecatedTypes\TimeOnlyType::class,
            Types\DateTimeType::class,
            ['format' => 's:i']
        ];

        yield [
            DeprecatedTypes\TxtboxType::class,
            Types\StringType::class,
            [
                'maxLength' => 255,
                'autoFormatingDisabled' => true
            ]
        ];

        yield [
            DeprecatedTypes\UrlType::class,
            Types\StringType::class,
            [
                'autoFormatingDisabled' => true,
                'validateRule' => ValidationRule::LINKS->value
            ]
        ];

        yield [
            DeprecatedTypes\UrllinkType::class,
            Types\IntegerType::class,
            [
                'autoFormatingDisabled' => true,
                'validateRule' => ValidationRule::LINKS->value,
                'data_handler' => 'link'
            ]
        ];
    }
}
