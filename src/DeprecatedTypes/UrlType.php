<?php

namespace Imponeer\Properties\DeprecatedTypes;


use Imponeer\Properties\DeprecatedDataTypeInterface;
use Imponeer\Properties\PropertiesInterface;
use Imponeer\Properties\Types\StringType;

/**
 * Class UrlType
 * @package Imponeer\Properties\DeprecatedTypes
 * @deprecated
 */
class UrlType extends StringType {
	/**
	 * @inheritDoc
	 */
	public $autoFormatingDisabled = true;

	/**
	 * @inheritDoc
	 */
	public $validateRule = PropertiesInterface::VALIDATION_RULE_LINKS;
}