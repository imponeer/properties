<?php

namespace IPFLibraries\Properties\CommonVariables;

use IPFLibraries\Properties\CommonVariableInterface;
use IPFLibraries\Properties\PropertiesSupport as Properties;

/**
 * Meta description field type
 *
 * @package IPFLibraries\Properties\CommonVariables
 */
class MetaDescription implements CommonVariableInterface {
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
		return Properties::DTYPE_STRING;
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
			'form_caption' => _CO_ICMS_META_DESCRIPTION,
			Properties::VARCFG_MAX_LENGTH => 160,
			'options' => '',
			'multilingual' => false,
			'form_dsc' => _CO_ICMS_META_DESCRIPTION_DSC,
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
			'name' => 'textarea',
			'form_editor'=>'textarea'
		];
	}

}