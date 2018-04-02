<?php

namespace Imponeer\Properties\DeprecatedTypes;


use Imponeer\Properties\DeprecatedDataTypeInterface;
use Imponeer\Properties\Types\StringType;

/**
 * Class TxtboxType
 * @package Imponeer\Properties\DeprecatedTypes
 * @deprecated
 */
class TxtboxType extends StringType {

	/**
	 * @inheritDoc
	 */
	public $maxLength = 255;

	/**
	 * @inheritDoc
	 */
	public $autoFormatingDisabled = true;
}