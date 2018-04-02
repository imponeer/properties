<?php

namespace Imponeer\Properties\DeprecatedTypes;


use Imponeer\Properties\DeprecatedDataTypeInterface;
use Imponeer\Properties\Types\StringType;

/**
 * Class SourceType
 * @package Imponeer\Properties\DeprecatedTypes
 * @deprecated
 */
class SourceType extends StringType {

	/**
	 * @inheritDoc
	 */
	public $sourceFormating = 'php';

	/**
	 * @inheritDoc
	 */
	public $autoFormatingDisabled = true;
}