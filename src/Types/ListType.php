<?php

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;

/**
 * Defines list type
 *
 * @package Imponeer\Properties\Types
 */
class ListType extends AbstractType {

	/**
	 * Separator
	 *
	 * @var string
	 */
	public $separator = ';';

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
		return $this->value;
	}

	/**
	 * @inheritDoc
	 */
	public function getForEdit() {
		return $this->get();
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
		if ((array) ($value) === $value) {
			return $value;
		}
		if (empty($value)) {
			return array();
		}
		if (is_string($value)) {
			return explode($this->separator, strval($value));
		} else {
			return array($value);
		}
	}
}