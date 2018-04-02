<?php

namespace Imponeer\Properties\Types;


use Imponeer\Properties\AbstractType;

class BooleanType extends AbstractType {

	/**
	 * @inheritDoc
	 */
	public function isDefined() {
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function getForDisplay() {
		return $this->value?_YES:_NO;
	}

	/**
	 * @inheritDoc
	 */
	public function getForEdit() {
		return str_replace(array("&amp;", "&nbsp;"), array('&', '&amp;nbsp;'), @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));

	}

	/**
	 * @inheritDoc
	 */
	public function getForForm() {
		return str_replace(array("&amp;", "&nbsp;"), array('&', '&amp;nbsp;'), @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));
	}

	/**
	 * @inheritDoc
	 */
	protected function clean($value) {
		if (is_bool($value)) {
			return $value;
		}
		if (!is_string($value)) {
			if (is_object($value)) {
				return true;
			} elseif (is_null($value)) {
				return false;
			}
			return (bool) intval($value);
		}
		$value = strtolower($value);
		return ($value == 'yes') || ($value == 'true');
	}
}