<?php

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\DeprecatedDataTypeInterface;
use Imponeer\Properties\Types\DateTimeType;

/**
 * Class MtimeType
 * @package Imponeer\Properties\DeprecatedTypes
 * @deprecated
 */
class MtimeType extends DateTimeType {
	/**
	 * @inheritDoc
	 */
	public $format = _MEDIUMDATESTRING;

}