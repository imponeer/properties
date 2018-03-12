<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 7:28 PM
 */

namespace IPFLibraries\Properties\DeprecatedTypes;

use IPFLibraries\Properties\DeprecatedDataTypeInterface;
use IPFLibraries\Properties\Types\DateTimeType;

/**
 * Class TimeOnlyType
 * @package IPFLibraries\Properties\DeprecatedTypes
 * @deprecated
 */
class TimeOnlyType extends DateTimeType {
	/**
	 * @inheritDoc
	 */
	public $format = 's:i';
}