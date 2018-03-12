<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 7:20 PM
 */

namespace IPFLibraries\Properties\DeprecatedTypes;

use IPFLibraries\Properties\DeprecatedDataTypeInterface;
use IPFLibraries\Properties\Types\DateTimeType;

/**
 * Class MtimeType
 * @package IPFLibraries\Properties\DeprecatedTypes
 * @deprecated
 */
class MtimeType extends DateTimeType {
	/**
	 * @inheritDoc
	 */
	public $format = _MEDIUMDATESTRING;

}