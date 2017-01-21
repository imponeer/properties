<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 1:17 AM
 */

namespace IPFLibraries\Properties\Types;


use IPFLibraries\Properties\AbstractType;

class BooleanType extends AbstractType
{

	/**
	 * @inheritDoc
	 */
	public function isDefined()
	{
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function getForDisplay()
	{
		return $this->value ? _YES : _NO;
	}

	/**
	 * @inheritDoc
	 */
	public function getForEdit()
	{
		return str_replace(array("&amp;", "&nbsp;"), array('&', '&amp;nbsp;'), @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));

	}

	/**
	 * @inheritDoc
	 */
	public function getForForm()
	{
		return str_replace(array("&amp;", "&nbsp;"), array('&', '&amp;nbsp;'), @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));
	}

	/**
	 * @inheritDoc
	 */
	protected function clean($value)
	{
		if (is_bool($value)) {
			return $value;
		}
		if (!is_string($value)) {
			return (bool)intval($value);
		}
		$value = strtolower($value);
		return ($value == 'yes') || ($value == 'true');
	}
}