<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Types;

use Imponeer\Properties\PropertiesInterface;
use Imponeer\Properties\Tests\TestTypeAbstract;

class DateTimeTypeTest extends TestTypeAbstract
{
    /**
     * Tests if initial was null
     */
    public function testIfInitialWasNull(): void
    {
        $this->assertNull(
            $this->mock->v,
            'DTYPE_DATETIME must have null unconverted'
        );
    }

    /**
     * Test conversions when setting var
     */
    public function testConversions(): void
    {
        foreach ($this->test_data as $v) {
            $this->mock->v = $v;
            $this->assertTrue(
                is_int($this->mock->v) || (is_object($this->mock->v) && $this->mock->v instanceof \DateTime),
                sprintf(
                    "DTYPE_DATETIME must convert all data (%s)",
                    var_export(['original' => $v, 'cleaned' => $this->mock->v], true)
                )
            );
        }
    }

    /**
     * @inheritdoc
     */
    protected function getDataType(): int
    {
        return PropertiesInterface::DTYPE_DATETIME;
    }
}
