<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Attribute;

use Imponeer\Properties\Attribute\LinkedCaseType;
use Imponeer\Properties\Enum\DataType;
use Imponeer\Properties\Types\StringType;
use PHPUnit\Framework\TestCase;
use ReflectionEnum;

class LinkedCaseTypeTest extends TestCase
{
    public function testStoresClassName(): void
    {
        $attribute = new LinkedCaseType(StringType::class);

        $this->assertSame(StringType::class, $attribute->class);
    }

    public function testAttributeAttachedToEnumCase(): void
    {
        $reflection = new ReflectionEnum(DataType::class);
        $case = $reflection->getCase('STRING');
        $attributes = $case->getAttributes(LinkedCaseType::class);

        $this->assertNotEmpty($attributes);

        $attribute = $attributes[0]->newInstance();
        $this->assertSame(StringType::class, $attribute->class);
    }
}
