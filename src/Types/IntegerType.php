<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 12:27 AM
 */

namespace IPFLibraries\Properties\Types;


use IPFLibraries\Properties\AbstractType;

class IntegerType extends AbstractType
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
		return (string)$this->value;
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
		if (is_object($value)) {
			return 0;
		}
		return (int)$value;
	}

}