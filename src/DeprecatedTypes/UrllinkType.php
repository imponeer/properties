<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 7:45 PM
 */

namespace IPFLibraries\Properties\DeprecatedTypes;

use IPFLibraries\Properties\DeprecatedDataTypeInterface;
use IPFLibraries\Properties\PropertiesInterface;
use IPFLibraries\Properties\Types\IntegerType;

/**
 * Class UrllinkType
 * @package IPFLibraries\Properties\DeprecatedTypes
 * @deprecated
 */
class UrllinkType extends IntegerType {

	/**
	 * @inheritDoc
	 */
	public $autoFormatingDisabled = true;

	/**
	 * @inheritDoc
	 */
	public $validateRule = PropertiesInterface::VALIDATION_RULE_LINKS;

	/**
	 * @inheritDoc
	 */
	public $data_handler = 'link';
}