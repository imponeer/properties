<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 7:21 PM
 */

namespace IPFLibraries\Properties\DeprecatedTypes;


use IPFLibraries\Properties\DeprecatedDataTypeInterface;
use IPFLibraries\Properties\Types\DateTimeType;

/**
 * Class StimeType
 * @package IPFLibraries\Properties\DeprecatedTypes
 * @deprecated
 */
class StimeType extends DateTimeType
{

	/**
	 * @inheritDoc
	 */
	public $format = _SHORTDATESTRING;
}