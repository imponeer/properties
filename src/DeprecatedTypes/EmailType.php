<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 7:50 PM
 */

namespace IPFLibraries\Properties\DeprecatedTypes;


use IPFLibraries\Properties\DeprecatedDataTypeInterface;
use IPFLibraries\Properties\PropertiesInterface;
use IPFLibraries\Properties\Types\StringType;

/**
 * Class EmailType
 *
 * @package IPFLibraries\Properties\DeprecatedTypes
 * @deprecated
 */
class EmailType extends StringType
{

	/**
	 * @inheritDoc
	 */
	public $autoFormatingDisabled = true;

	/**
	 * @inheritDoc
	 */
	public $validateRule = PropertiesInterface::VALIDATION_RULE_EMAIL;
}