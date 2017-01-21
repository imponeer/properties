<?php

namespace IPFLibraries\Properties\CommonVariables;

use IPFLibraries\Properties\CommonVariableInterface;
use IPFLibraries\Properties\PropertiesSupport as Properties;

/**
 * Do Image field type
 *
 * @package IPFLibraries\Properties\CommonVariables
 */
class Doimage implements CommonVariableInterface {
	/**
	 * @inheritDoc
	 */
	public function parseValue($default)
	{
		return $default != 'notdefined' ? $default : 0;
	}

	/**
	 * @inheritDoc
	 */
	public function getDataType()
	{
		return Properties::DTYPE_INTEGER;
	}

	/**
	 * @inheritDoc
	 */
	public function isRequired()
	{
		return false;
	}

	/**
	 * @inheritDoc
	 */
	public function getOtherConfig()
	{
		return [
			'form_caption' => _CO_ICMS_DOIMAGE_FORM_CAPTION,
			Properties::VARCFG_MAX_LENGTH => null,
			'options' => '',
			'multilingual' => false,
			'form_dsc' => '',
			'sortby' => false,
			'persistent' => true
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getControl()
	{
		return [
			'name' => 'yesno'
		];
	}

}