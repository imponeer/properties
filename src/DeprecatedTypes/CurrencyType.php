<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 7:17 PM
 */

namespace IPFLibraries\Properties\DeprecatedTypes;

use IPFLibraries\Properties\DeprecatedDataTypeInterface;
use IPFLibraries\Properties\Types\FloatType;

/**
 * CurrencyType
 *
 * @package IPFLibraries\Properties\DeprecatedTypes
 * @deprecated
 */
class CurrencyType extends FloatType {

	/**
	 * @inheritDoc
	 */
	public $format = '%d';
}