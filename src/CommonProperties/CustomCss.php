<?php

namespace IPFLibraries\Properties\CommonProperties;

use IPFLibraries\Properties\CommonPropertyInterface;
use IPFLibraries\Properties\ConfigOption;
use IPFLibraries\Properties\DataType;

/**
 * Custom CSS field type
 *
 * @package IPFLibraries\Properties\CommonVariables
 */
class CustomCss implements CommonPropertyInterface
{
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
		return DataType::STRING;
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
			ConfigOption::FORM_CAPTION => _CO_ICMS_CUSTOM_CSS,
			ConfigOption::MAX_LENGTH => null,
			'options' => '',
			'multilingual' => false,
			ConfigOption::FORM_DESC => _CO_ICMS_CUSTOM_CSS_DSC,
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