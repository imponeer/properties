<?php

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\DeprecatedDataTypeInterface;
use Imponeer\Properties\Types\IntegerType;

/**
 * Class ImageType
 * @package Imponeer\Properties\DeprecatedTypes
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