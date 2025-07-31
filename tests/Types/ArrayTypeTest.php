<?php

declare(strict_types=1);

namespace Imponeer\Properties\Tests\Types;

use Imponeer\Properties\PropertiesInterface;
use Imponeer\Properties\Tests\TestTypeAbstract;

class ArrayTypeTest extends TestTypeAbstract
{
    /**
     * Tests if initial was null
     */
    public function testIfInitialWasNull(): void
    {
        $this->assertNotNull($this->mock->v, 'DTYPE_ARRAY must have null unconverted');
    }

    /**
     * Tests JSON decode
     */
    public function testJsonDecode(): void
    {
        foreach ($this->test_data as $v) {
            if (is_object($v) && ($v instanceof \Closure)) {
                continue;
            }
            $this->mock->v = json_encode($v);
            $this->assertIsArray($this->mock->v, 'DTYPE_ARRAY must parse json to array (' . var_export(['original' => $v, 'cleaned' => $this->mock->v], true) . ')');
        }
    }

    /**
     * Tests PHP unserialize
     */
    public function testUnserialize(): void
    {
        foreach ($this->test_data as $v) {
            if (is_object($v) && ($v instanceof \Closure)) {
                continue;
            }
            $this->mock->v = serialize($v);
            $this->assertIsArray($this->mock->v, 'DTYPE_ARRAY must unserialize to array (' . var_export(['original' => $v, 'cleaned' => $this->mock->v], true) . ')');
        }
    }

    /**
     * Test conversions when setting var
     */
    public function testConversions(): void
    {
        foreach ($this->test_data as $v) {
            if (is_string($v)) {
                continue;
            }
            $this->mock->v = $v;
            $this->assertIsArray($this->mock->v, 'DTYPE_ARRAY must convert all data');
            if (is_array($v)) {
                $this->assertSame($v, $this->mock->v, 'Array must be unchanged');
            } else {
                $this->assertSame((array)$v, array_values($this->mock->v), 'Simple values must be converted as array values without modifications (' . var_export(['original' => $v, 'cleaned' => $this->mock->v], true) . ')');
            }
        }
    }

    /**
     * @inheritdoc
     */
    protected function getDataType(): int
    {
        return PropertiesInterface::DTYPE_ARRAY;
    }
}