<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 7:34 PM
 */

namespace IPFLibraries\Properties\DeprecatedTypes;


use IPFLibraries\Properties\DeprecatedDataTypeInterface;
use IPFLibraries\Properties\Types\StringType;

/**
 * Class SourceType
 * @package IPFLibraries\Properties\DeprecatedTypes
 * @deprecated
 */
class SourceType extends StringType
{

	/**
	 * @inheritDoc
	 */
	public $sourceFormating = 'php';

	/**
	 * @inheritDoc
	 */
	public $autoFormatingDisabled = true;
}