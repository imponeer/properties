<?php

namespace Imponeer\Properties\Tests\Types;

use Imponeer\Properties\PropertiesInterface;
use Imponeer\Properties\Tests\TestTypeAbstract;

class ObjectTypeTest extends TestTypeAbstract
{

	/**
	 * Tests if initial was null
	 */
	public function testIfInitialWasNull()
	{
		$this->assertInternalType('null', $this->mock->v, 'DTYPE_OBJECT must have null unconverted');
	}

	/**
	 * Tests JSON decode
	 */
	public function testJsonDecode()
	{
		foreach ($this->test_data as $v) {
			$this->mock->v = json_encode($v);
			if ($v === null) {
				$this->assertInternalType('null', $this->mock->v, 'DTYPE_OBJECT must parse json null to null');
			} else {
				$this->assertInternalType('object', $this->mock->v, 'DTYPE_OBJECT must parse json to object (' . json_encode($v) . ')');
			}
		}
	}

	/**
	 * Tests PHP unserialize
	 */
	public function testUnserialize()
	{
		foreach ($this->test_data as $v) {
			$this->mock->v = serialize($v);
			if ($v === null) {
				$this->assertInternalType('null', $this->mock->v, 'DTYPE_OBJECT must unserialize null to null');
			} else {
				$this->assertInternalType('object', $this->mock->v, 'DTYPE_OBJECT must unserialize to object (' . json_encode($v) . ')');
			}
		}
	}

	/**
	 * Test if object from class name parses
	 */
	public function testNewClassFromString()
	{
		$this->mock->v = \DateTime::class;
		$this->assertInstanceOf(\DateTime::class, $this->mock->v, 'Object from class name doesn\'t parses');

		$this->mock->v = ' *@#%^';
		$this->assertNull($this->mock->v, 'Object from not existing class should parse to null');
	}

	/**
	 * Test conversions when setting var
	 */
	public function testConversions()
	{
		foreach ($this->test_data as $v) {
			$this->mock->v = $v;
			if ($v === null) {
				$this->assertInternalType('null', $this->mock->v, 'DTYPE_OBJECT must convert null to null');
			} else {
				$this->assertInternalType('object', $this->mock->v, 'DTYPE_OBJECT must convert all data (' . json_encode($v) . ')');
			}
		}
	}

	/**
	 * @inheritdoc
	 */
	protected function getDataType()
	{
		return PropertiesInterface::DTYPE_OBJECT;
	}
}