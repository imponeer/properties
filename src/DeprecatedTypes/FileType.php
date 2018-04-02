<?php

namespace Imponeer\Properties\DeprecatedTypes;


use Imponeer\Properties\DeprecatedDataTypeInterface;
use Imponeer\Properties\Types\IntegerType;

/**
 * Class FileType
 * @package Imponeer\Properties\DeprecatedTypes
 * @deprecated
 */
class FileType extends IntegerType {
	/**
	 * @inheritDoc
	 */
	public $data_handler = 'file';

	/**
	 * @inheritDoc
	 */
	public $autoFormatingDisabled = true;
}