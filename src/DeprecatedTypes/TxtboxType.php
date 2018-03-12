<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 7:51 PM
 */

namespace IPFLibraries\Properties\DeprecatedTypes;


use IPFLibraries\Properties\DeprecatedDataTypeInterface;
use IPFLibraries\Properties\Types\StringType;

/**
 * Class TxtboxType
 * @package IPFLibraries\Properties\DeprecatedTypes
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