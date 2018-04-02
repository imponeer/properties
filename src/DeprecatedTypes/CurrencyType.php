<?php

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\DeprecatedDataTypeInterface;
use Imponeer\Properties\Types\FloatType;

/**
 * CurrencyType
 *
 * @package Imponeer\Properties\DeprecatedTypes
 * @deprecated
 */
class CurrencyType extends FloatType {

	/**
	 * @inheritDoc
	 */
	public $format = '%d';
}