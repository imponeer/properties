<?php

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\DeprecatedDataTypeInterface;
use Imponeer\Properties\PropertiesInterface;
use Imponeer\Properties\Types\IntegerType;

/**
 * Class UrllinkType
 * @package Imponeer\Properties\DeprecatedTypes
 * @deprecated
 */
class UrllinkType extends IntegerType {

	/**
	 * @inheritDoc
	 */
	public $autoFormatingDisabled = true;

	/**
	 * @inheritDoc
	 */
	public $validateRule = PropertiesInterface::VALIDATION_RULE_LINKS;

	/**
	 * @inheritDoc
	 */
	public $data_handler = 'link';
}