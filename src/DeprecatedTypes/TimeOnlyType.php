<?php

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\DeprecatedDataTypeInterface;
use Imponeer\Properties\Types\DateTimeType;

/**
 * Class TimeOnlyType
 * @package Imponeer\Properties\DeprecatedTypes
 * @deprecated
 */
class TimeOnlyType extends DateTimeType {
	/**
	 * @inheritDoc
	 */
	public $format = 's:i';
}