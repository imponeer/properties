<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\CommonProperties;

use Imponeer\Properties\CommonProperties;
use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\Service\ServiceLocator;
use Imponeer\Properties\Types\ArrayType;
use Imponeer\Properties\Types\IntegerType;
use Imponeer\Properties\Types\StringType;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class CommonPropertiesTest extends TestCase
{
    protected function setUp(): void
    {
        ServiceLocator::setContainer(
            new class implements ContainerInterface {
                public function get(string $id): mixed
                {
                    throw new \RuntimeException('not available');
                }

                public function has(string $id): bool
                {
                    return false;
                }
            }
        );
        parent::setUp();
    }

    #[DataProvider('propertyProvider')]
    public function testCommonPropertyImplementation(
        string $class,
        string $expectedDataType,
        ?array $expectedControl,
        array $expectedOtherConfig
    ): void {
        $property = new $class();

        $this->assertInstanceOf(CommonPropertyInterface::class, $property);
        $this->assertSame(0, $property->parseValue('notdefined'));
        $this->assertSame('value', $property->parseValue('value'));
        $this->assertSame($expectedDataType, $property->getDataType());
        $this->assertFalse($property->isRequired());
        $this->assertSame($expectedControl, $property->getControl());
        $this->assertSame($expectedOtherConfig, $property->getOtherConfig());
    }

    public static function propertyProvider(): iterable
    {
        yield [
            CommonProperties\Counter::class,
            IntegerType::class,
            null,
            [
                'form_caption' => '_CO_ICMS_COUNTER_FORM_CAPTION',
                'maxLength' => null,
                'options' => '',
                'multilingual' => false,
                'form_desc' => '',
                'sortby' => false,
                'persistent' => true
            ]
        ];

        yield [
            CommonProperties\CustomCss::class,
            StringType::class,
            [
                'name' => 'textarea',
                'form_editor' => 'textarea'
            ],
            [
                'form_caption' => '_CO_ICMS_CUSTOM_CSS',
                'maxLength' => null,
                'options' => '',
                'multilingual' => false,
                'form_desc' => '_CO_ICMS_CUSTOM_CSS_DSC',
                'sortby' => false,
                'persistent' => true
            ]
        ];

        yield [
            CommonProperties\Dobr::class,
            IntegerType::class,
            ['name' => 'yesno'],
            [
                'form_caption' => '_CM_DOAUTOWRAP',
                'maxLength' => null,
                'options' => '',
                'multilingual' => false,
                'form_desc' => '',
                'sortby' => false,
                'persistent' => true
            ]
        ];

        yield from self::getDocxodeLikeProviders();

        yield [
            CommonProperties\Dohtml::class,
            IntegerType::class,
            ['name' => 'yesno'],
            [
                'form_caption' => '_CM_DOHTML',
                'maxLength' => null,
                'options' => '',
                'multilingual' => false,
                'form_desc' => '',
                'sortby' => false,
                'persistent' => true
            ]
        ];

        yield [
            CommonProperties\Doimage::class,
            IntegerType::class,
            ['name' => 'yesno'],
            [
                'form_caption' => '_CO_ICMS_DOIMAGE_FORM_CAPTION',
                'maxLength' => null,
                'options' => '',
                'multilingual' => false,
                'form_desc' => '',
                'sortby' => false,
                'persistent' => true
            ]
        ];

        yield [
            CommonProperties\Dosmiley::class,
            IntegerType::class,
            ['name' => 'yesno'],
            [
                'form_caption' => '_CM_DOSMILEY',
                'maxLength' => null,
                'options' => '',
                'multilingual' => false,
                'form_desc' => '',
                'sortby' => false,
                'persistent' => true
            ]
        ];

        yield [
            CommonProperties\HierarchyPath::class,
            ArrayType::class,
            null,
            [
                'form_caption' => '_CO_ICMS_HIERARCHY_PATH',
                'maxLength' => null,
                'options' => '',
                'multilingual' => false,
                'form_desc' => '_CO_ICMS_HIERARCHY_PATH_DSC',
                'sortby' => false,
                'persistent' => true
            ]
        ];

        yield [
            CommonProperties\MetaDescription::class,
            StringType::class,
            [
                'name' => 'textarea',
                'form_editor' => 'textarea'
            ],
            [
                'form_caption' => '_CO_ICMS_META_DESCRIPTION',
                'maxLength' => 160,
                'options' => '',
                'multilingual' => false,
                'form_desc' => '_CO_ICMS_META_DESCRIPTION_DSC',
                'sortby' => false,
                'persistent' => true
            ]
        ];

        yield [
            CommonProperties\MetaKeywords::class,
            StringType::class,
            [
                'name' => 'textarea',
                'form_editor' => 'textarea'
            ],
            [
                'form_caption' => '_CO_ICMS_META_KEYWORDS',
                'maxLength' => 255,
                'options' => '',
                'multilingual' => false,
                'form_desc' => '_CO_ICMS_META_KEYWORDS_DSC',
                'sortby' => false,
                'persistent' => true
            ]
        ];

        yield [
            CommonProperties\ShortUrl::class,
            StringType::class,
            null,
            [
                'form_caption' => '_CO_ICMS_SHORT_URL',
                'maxLength' => 255,
                'options' => '',
                'multilingual' => false,
                'form_desc' => '_CO_ICMS_SHORT_URL_DSC',
                'sortby' => false,
                'persistent' => true
            ]
        ];

        yield [
            CommonProperties\Weight::class,
            IntegerType::class,
            null,
            [
                'form_caption' => '_CO_ICMS_WEIGHT_FORM_CAPTION',
                'maxLength' => null,
                'options' => '',
                'multilingual' => false,
                'form_desc' => '',
                'sortby' => true,
                'persistent' => true
            ]
        ];
    }

    private static function getDocxodeLikeProviders(): iterable
    {
        $config = [
            'form_caption' => '_CO_ICMS_DOXCODE_FORM_CAPTION',
            'maxLength' => null,
            'options' => '',
            'multilingual' => false,
            'form_desc' => '',
            'sortby' => false,
            'persistent' => true
        ];

        yield [
            CommonProperties\Doxcode::class,
            IntegerType::class,
            ['name' => 'yesno'],
            $config
        ];

        yield [
            CommonProperties\Docxode::class,
            IntegerType::class,
            ['name' => 'yesno'],
            $config
        ];
    }
}
