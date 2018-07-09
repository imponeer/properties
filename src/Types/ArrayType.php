<?php

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;

/**
 * Defines array type
 *
 * @package Imponeer\Properties\Types
 */
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
		if (empty($value) && !is_numeric($value)) {
			return array();
		}
		if (is_string($value)) {
			return $this->unserializeValue($value);
		}
		return (array) $value;
	}

	/**
	 * Unserialize value from string when cleaning it
	 *
	 * @param string $value Value to unserialize
	 *
	 * @return null|array
	 */
	protected function unserializeValue($value)
	{
		if ($value[0] == '{' || $value[0] == '[') {
			return (array)json_decode($value, true);
		} elseif (in_array(substr($value, 0, 2), ['O:', 'a:'])) {
			return (array)unserialize($value);
		} elseif (is_numeric($value)) {
			return (array)$value;
		} else {
			return [];
		}
	}

}