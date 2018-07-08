<?php

namespace Imponeer\Properties\Tests;

use Imponeer\Properties\PropertiesInterface;
use Imponeer\Properties\PropertiesSupport;
use PHPUnit\Framework\TestCase;

/**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class PropertiesSupportTest extends TestCase
{

	/**
	 * Current mock
	 *
	 * @var PropertiesSupport
	 */
	protected $mock;

	/**
	 * Set ups test
	 */
	public function setUp()
	{
		$this->mock = $this->getMockForTrait(PropertiesSupport::class);

		parent::setUp();
	}

	/**
	 * Tests that all needed public methods exists
	 */
	public function testNeededPublicMethods()
	{
		foreach ([
					 'getVar' => null,
					 'setVar' => null,
					 'assignVar' => null,
					 'assignVars' => null,
					 'getChangedVars' => 'array',
					 'getDefaultVars' => 'array',
					 'getProblematicVars' => 'array',
					 'getValues' => 'array',
					 'getVarForDisplay' => null,
					 'getVarForEdit' => null,
					 'getVarForForm' => null,
					 'getVarInfo' => null,
					 'getVarNames' => null,
					 'getVars' => 'array',
					 'isChanged' => 'bool',
					 'setVarInfo' => null,
					 'toArray' => 'array',
				 ] as $method => $retType) {
			$this->assertTrue(method_exists($this->mock, $method), 'No public ' . $method . ' method');
			if ($retType !== null) {
				$this->assertInternalType($retType, $this->mock->$method(), "$method returns wrong data type");
			}
		}
	}

	/**
	 * Tests if initVars works
	 */
	public function testInitVars()
	{
		$reflection_method = new \ReflectionMethod($this->mock, 'initVar');
		$this->assertTrue(is_object($reflection_method), 'initVar method doesn\'t exists');
		$this->assertTrue($reflection_method->isProtected(), 'initVar method doesn\'t is protected');

		$reflection_method->setAccessible(true);

		$this->assertCount(0, $this->mock->getVars(), 'Properties creates object with existing vars. This must not be possible for new objects.');

		$reflection_method->invoke($this->mock, 'var_array', PropertiesInterface::DTYPE_ARRAY, array(), false);

		$vars = $this->mock->getVars();
		$this->assertCount(1, $vars, 'Couln\'t init var');
		$this->assertArrayHasKey('var_array', $vars, 'Couln\'t init var');

		$this->assertTrue(isset($this->mock->var_array), 'Can\'t use fast property access (withou calling function)');

		$this->assertInternalType('array', $this->mock->getVar('var_array'), 'When tried to read just cread var wrong data returned');
		$this->assertInternalType('array', $this->mock->var_array, 'When tried to read just cread var wrong data returned');
	}

}