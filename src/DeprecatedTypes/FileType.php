<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 8:15 PM
 */

namespace IPFLibraries\Properties\DeprecatedTypes;


use IPFLibraries\Properties\DeprecatedDataTypeInterface;
use IPFLibraries\Properties\Types\IntegerType;

/**
 * Class FileType
 * @package IPFLibraries\Properties\DeprecatedTypes
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