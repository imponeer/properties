<?php

namespace IPFLibraries\Properties\CommonProperties;

use IPFLibraries\Properties\CommonPropertyInterface;
use IPFLibraries\Properties\ConfigOption;
use IPFLibraries\Properties\DataType;

/**
 * Meta description field type
 *
 * @package IPFLibraries\Properties\CommonVariables
 */
class MetaDescription implements CommonPropertyInterface
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
			ConfigOption::FORM_CAPTION => _CO_ICMS_META_DESCRIPTION,
			ConfigOption::MAX_LENGTH => 160,
			'options' => '',
			'multilingual' => false,
			ConfigOption::FORM_DESC => _CO_ICMS_META_DESCRIPTION_DSC,
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