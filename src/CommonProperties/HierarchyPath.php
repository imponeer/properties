<?php

namespace IPFLibraries\Properties\CommonProperties;

use IPFLibraries\Properties\CommonPropertyInterface;
use IPFLibraries\Properties\ConfigOption;
use IPFLibraries\Properties\DataType;
use IPFLibraries\Properties\Types\ArrayType;

/**
 * Hierarchy path field type
 *
 * @package IPFLibraries\Properties\CommonVariables
 */
class HierarchyPath implements CommonPropertyInterface {
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
		return ArrayType::class;
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
			'form_caption' => _CO_ICMS_HIERARCHY_PATH,
			'maxLength' => null,
			'options' => '',
			'multilingual' => false,
			'form_desc' => _CO_ICMS_HIERARCHY_PATH_DSC,
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