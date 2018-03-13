<?php

namespace IPFLibraries\Properties\CommonProperties;

use IPFLibraries\Properties\CommonPropertyInterface;
use IPFLibraries\Properties\ConfigOption;
use IPFLibraries\Properties\DataType;
use IPFLibraries\Properties\Types\IntegerType;

/**
 * Counter field type
 *
 * @package IPFLibraries\Properties\CommonVariables
 */
class Counter implements CommonPropertyInterface {
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
		return IntegerType::class;
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
			'form_caption' => _CO_ICMS_COUNTER_FORM_CAPTION,
			'maxLength' => null,
			'options' => '',
			'multilingual' => false,
			'form_desc' => '',
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