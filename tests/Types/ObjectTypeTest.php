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
			if (is_null($v) || is_bool($v) || is_numeric($v) || is_string($v)) {
				$this->assertInternalType('null', $this->mock->v, 'DTYPE_OBJECT must parse json to null if is not object or array (' . var_export(['original' => $v, 'cleaned' => $this->mock->v], true) . ')');
			} else {
				$this->assertInternalType('object', $this->mock->v, 'DTYPE_OBJECT must parse json to object (' . var_export(['original' => $v, 'cleaned' => $this->mock->v], true) . ')');
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
			if (is_null($v) || is_bool($v) || is_numeric($v) || is_string($v)) {
				$this->assertInternalType('null', $this->mock->v, 'DTYPE_OBJECT must unserialize to null if is not object or array (' . var_export(['original' => $v, 'cleaned' => $this->mock->v], true) . ')');
			} else {
				$this->assertInternalType('object', $this->mock->v, 'DTYPE_OBJECT must unserialize to object (' . var_export(['original' => $v, 'cleaned' => $this->mock->v], true) . ')');
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
			if (is_string($v)) {
				continue;
			}
			$this->mock->v = $v;
			if ($v === null) {
				$this->assertInternalType('null', $this->mock->v, 'DTYPE_OBJECT must convert null to null');
			} else {
				$this->assertInternalType('object', $this->mock->v, 'DTYPE_OBJECT must convert all data (' . var_export(['original' => $v, 'cleaned' => $this->mock->v], true) . ')');
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