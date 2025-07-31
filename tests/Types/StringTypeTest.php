<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Types;

use Imponeer\Properties\PropertiesInterface;
use Imponeer\Properties\Tests\TestTypeAbstract;

class StringTypeTest extends TestTypeAbstract
{
    /**
     * Tests if initial was null
     */
    public function testIfInitialWasNull(): void
    {
        $this->assertNull($this->mock->v, 'DTYPE_STRING must have null unconverted');
    }

    /**
     * Test conversions when setting var
     */
    public function testConversions(): void
    {
        foreach ($this->test_data as $v) {
            if (is_object($v) && ($v instanceof \Closure)) {
                continue;
            }
            $this->mock->v = $v;
            $this->assertIsString($this->mock->v, 'DTYPE_STRING must convert all data (' . var_export(['original' => $v, 'cleaned' => $this->mock->v], true) . ')');
        }
    }

    /**
     * @inheritdoc
     */
    protected function getDataType(): int
    {
        return PropertiesInterface::DTYPE_STRING;
    }
}
