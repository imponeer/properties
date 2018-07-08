<?php

namespace Imponeer\Properties\Tests\Types;

use Imponeer\Properties\PropertiesInterface;
use Imponeer\Properties\Tests\TestTypeAbstract;

class BooleanTypeTest extends TestTypeAbstract
{

	/**
	 * Tests if initial was null
	 */
	public function testIfInitialWasNull()
	{
		$this->assertInternalType('null', $this->mock->v, 'DTYPE_BOOLEAN must have null unconverted');
	}

	/**
	 * Test conversions when setting var
	 */
	public function testConversions()
	{
		foreach ($this->test_data as $v) {
			$this->mock->v = $v;
			$this->assertInternalType('bool', $this->mock->v, 'DTYPE_BOOLEAN must convert all data (' . json_encode($v) . ')');
		}
	}

	/**
	 * @inheritdoc
	 */
	protected function getDataType()
	{
		return PropertiesInterface::DTYPE_BOOLEAN;
	}
}