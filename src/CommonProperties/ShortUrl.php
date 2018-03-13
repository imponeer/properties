<?php

namespace IPFLibraries\Properties\CommonProperties;

use IPFLibraries\Properties\CommonPropertyInterface;
use IPFLibraries\Properties\ConfigOption;
use IPFLibraries\Properties\DataType;
use IPFLibraries\Properties\Types\StringType;

/**
 * Short URL field type
 *
 * @package IPFLibraries\Properties\CommonVariables
 */
class ShortUrl implements CommonPropertyInterface {
	/**
	 * @inheritDoc
	 */
	public function parseValue($default) {
		return $default != 'notdefined'?$default:0;
	}

	/**
	 * @inheritDoc
	 */
	public function getDataType() {
		return StringType::class;
	}

	/**
	 * @inheritDoc
	 */
	public function isRequired() {
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function getOtherConfig() {
		return [
			'form_caption' => _CO_ICMS_SHORT_URL,
			'maxLength' => 255,
			'options' => '',
			'multilingual' => false,
			'form_desc' => _CO_ICMS_SHORT_URL_DSC,
			'sortby' => false,
			'persistent' => true
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getControl() {
		return null;
	}

}