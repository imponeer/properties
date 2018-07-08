<?php

namespace Imponeer\Properties\Tests\Types;

use Imponeer\Properties\PropertiesInterface;
use Imponeer\Properties\Tests\TestTypeAbstract;

class ArrayTypeTest extends TestTypeAbstract
{

	/**
	 * Tests if initial was null
	 */
	public function testIfInitialWasNull()
	{
		$this->assertInternalType('null', $this->mock->v, 'DTYPE_ARRAY must have null unconverted');
	}

	/**
	 * Test conversions when setting var
	 */
	public function testConversions()
	{
		foreach ($this->test_data as $v) {
			$this->mock->v = $v;
			$this->assertInternalType('array', $this->mock->v, 'DTYPE_ARRAY must convert all data');
			if (is_array($v)) {
				$this->assertSame($v, $this->mock->v, 'Array must be unchanged');
			} else {
				$this->assertSame((array)$v, array_values($this->mock->v), 'Simple values must be converted as array values without modifications (' . json_encode($v) . ')');
			}
		}
	}

	/**
	 * @inheritdoc
	 */
	protected function getDataType()
	{
		return PropertiesInterface::DTYPE_ARRAY;
	}
}