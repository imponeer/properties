<?php

namespace IPFLibraries\Properties\CommonProperties;

use IPFLibraries\Properties\CommonPropertyInterface;
use IPFLibraries\Properties\ConfigOption;
use IPFLibraries\Properties\DataType;
use IPFLibraries\Properties\Types\IntegerType;

/**
 * Do br field type
 *
 * @package IPFLibraries\Properties\CommonVariables
 */
class Dobr implements CommonPropertyInterface {
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
		if (!defined('_CM_DOAUTOWRAP')) {
			icms_loadLanguageFile('core', 'comment');
		}
		return [
			'form_caption' => _CM_DOAUTOWRAP,
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
		return [
			'name' => 'yesno'
		];
	}

}