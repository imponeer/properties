<?php

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\ConfigOption;
use Imponeer\Properties\DataType;
use Imponeer\Properties\Types\StringType;

/**
 * Short URL field type
 *
 * @package Imponeer\Properties\CommonVariables
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