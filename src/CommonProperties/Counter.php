<?php

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\ConfigOption;
use Imponeer\Properties\DataType;
use Imponeer\Properties\Types\IntegerType;

/**
 * Counter field type
 *
 * @package Imponeer\Properties\CommonVariables
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