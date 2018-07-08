<?php

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;

class ArrayType extends AbstractType {
	/**
	 * @inheritDoc
	 */
	public function isDefined() {
		return !empty($this->value);
	}

	/**
	 * @inheritDoc
	 */
	public function getForDisplay() {
		return json_encode($this->value, JSON_PRETTY_PRINT);
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
		if (((array) $value) === $value) {
			return $value;
		}
		if (empty($value)) {
			return array();
		}
		if (is_string($value)) {
			if (in_array(substr($value, 0, 1), array('{', '['))) {
				$ret = json_decode($value, true);
			} elseif (substr($value, 0, 2) == 'a:') {
				$ret = unserialize($value);
			}
			if (isset($ret) && ($ret !== null)) {
				return $ret;
			}
		}
		return (array) $value;
	}

}