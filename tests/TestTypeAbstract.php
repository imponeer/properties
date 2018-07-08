<?php

namespace Imponeer\Properties\Tests;

use Imponeer\Properties\PropertiesSupport;
use PHPUnit\Framework\TestCase;

abstract class TestTypeAbstract extends TestCase
{

	/**
	 * Test data
	 *
	 * @var array
	 */
	protected $test_data;

	/**
	 * Current mock
	 *
	 * @var PropertiesSupport
	 */
	protected $mock;

	/**
	 * SetsUp
	 */
	protected function setUp()
	{
		$this->createQuickMock();
		$this->generateTestData();

		parent::setUp();
	}

	/**
	 * Creates quick mock for test
	 */
	private function createQuickMock()
	{
		$this->mock = $this->getMockForTrait(PropertiesSupport::class);
		$reflection_method = new \ReflectionMethod($this->mock, 'initVar');
		$reflection_method->setAccessible(true);
		$reflection_method->invoke(
			$this->mock,
			'v',
			$this->getDataType(),
			$this->getDefaultValue(),
			$this->getRequired(),
			$this->getOtherConfig()
		);
	}

	/**
	 * Get datatype used for tests
	 *
	 * @return int
	 */
	protected abstract function getDataType();

	/**
	 * Gets default value for mockup var
	 *
	 * @return null
	 */
	protected function getDefaultValue()
	{
		return null;
	}

	/**
	 * Gets if var is required
	 *
	 * @return bool
	 */
	protected function getRequired()
	{
		return false;
	}

	/**
	 * Get other configuration options for mockup variable
	 *
	 * @return null|array
	 */
	protected function getOtherConfig()
	{
		return null;
	}

	/**
	 * Generates test data
	 */
	private function generateTestData()
	{
		$basic_test_data = [
			[],
			0,
			0.0,
			true,
			false,
			null,
			new \stdClass(),
			function () {
			},
			fopen('php://memory', 'w')
		];

		if (defined('PHP_INT_MIN')) {
			define('PHP_INT_MIN', -PHP_INT_MAX);
		}

		for ($i = 0; $i < 10; $i++) {
			$basic_test_data[] = mt_rand(1, PHP_INT_MAX);
			$basic_test_data[] = mt_rand(PHP_INT_MIN, -1);
			$basic_test_data[] = (float)(mt_rand(1, PHP_INT_MAX) / mt_getrandmax());
			$basic_test_data[] = (float)(mt_rand(PHP_INT_MIN, -1) / mt_getrandmax());
			$basic_test_data[] = str_shuffle(date('r'));
		}

		$arrayed_data = [];

		foreach ($basic_test_data as $data) {
			$arrayed_data[] = [$data];
			foreach ($basic_test_data as $key) {
				if (is_array($key) || is_object($key) || is_null($key) || is_resource($key)) {
					continue;
				}
				$arrayed_data[] = [$key => $data];
			}
		}

		$this->test_data = array_merge($basic_test_data, $arrayed_data);
	}

}