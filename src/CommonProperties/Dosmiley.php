<?php

namespace Imponeer\Properties\CommonProperties;

use Imponeer\Properties\CommonPropertyInterface;
use Imponeer\Properties\ConfigOption;
use Imponeer\Properties\DataType;
use Imponeer\Properties\Types\IntegerType;

/**
 * Do smiles? field type
 *
 * @package Imponeer\Properties\CommonVariables
 */
class Dosmiley implements CommonPropertyInterface {
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
		if (!defined('_CM_DOSMILEY')) {
			icms_loadLanguageFile('core', 'comment');
		}
		return [
			'form_caption' => _CM_DOSMILEY,
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