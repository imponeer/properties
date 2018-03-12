<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 7:53 PM
 */

namespace IPFLibraries\Properties\DeprecatedTypes;


use IPFLibraries\Properties\DeprecatedDataTypeInterface;
use IPFLibraries\Properties\Types\IntegerType;

/**
 * Class ImageType
 * @package IPFLibraries\Properties\DeprecatedTypes
 * @deprecated
 */
class ImageType extends IntegerType {

	/**
	 * @inheritDoc
	 */
	public $data_handler = 'image';

	/**
	 * @inheritDoc
	 */
	public $autoFormatingDisabled = true;

	/**
	 * Allowed mimetypes
	 *
	 * @var array
	 */
	public $allowedMimeTypes = [
		'image/gif',
		'image/jpeg',
		'image/pjpeg',
		'image/png',
		'image/svg+xml',
		'image/tiff',
		'image/vnd.microsoft.icon'
	];
}