<?php

namespace IPFLibraries\Properties\CommonProperties;

use IPFLibraries\Properties\CommonPropertyInterface;
use IPFLibraries\Properties\ConfigOption;
use IPFLibraries\Properties\DataType;

/**
 * Weight field type
 *
 * @package IPFLibraries\Properties\CommonVariables
 */
class Weight implements CommonPropertyInterface
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
		return DataType::INTEGER;
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
			ConfigOption::FORM_CAPTION => _CO_ICMS_WEIGHT_FORM_CAPTION,
			ConfigOption::MAX_LENGTH => null,
			'options' => '',
			'multilingual' => false,
			ConfigOption::FORM_DESC => '',
			'sortby' => true,
			'persistent' => true
		];
	}

	/**
	 * @inheritDoc
	 */
	public function getControl()
	{
		return null;
	}

}