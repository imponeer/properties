<?php

namespace Imponeer\Properties\DeprecatedTypes;


use Imponeer\Properties\DeprecatedDataTypeInterface;
use Imponeer\Properties\Types\DateTimeType;

/**
 * Class StimeType
 * @package Imponeer\Properties\DeprecatedTypes
 * @deprecated
 */
class StimeType extends DateTimeType {

	/**
	 * @inheritDoc
	 */
	public $format = _SHORTDATESTRING;
}