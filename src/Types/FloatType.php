<?php

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;

/**
 * Defines float type
 *
 * @package Imponeer\Properties\Types
 */
class FloatType extends AbstractType {

	/**
	 * Format output
	 *
	 * @var string
	 */
	public $format = '%d';

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
		return sprintf($this->format, $this->value);
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
		if (is_object($value)) {
			return 0.00;
		}
		return (float) $value;
	}

}