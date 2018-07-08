<?php

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;

/**
 * Defines object type
 *
 * @package Imponeer\Properties\Types
 */
class ObjectType extends AbstractType {

	/**
	 * @inheritDoc
	 */
	public function isDefined() {
		return is_object($this->value);
	}

	/**
	 * @inheritDoc
	 */
	public function getForDisplay() {
		return (string) $this->value;
	}

	/**
	 * @inheritDoc
	 */
	public function getForEdit() {
		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function getForForm() {
		return null;
	}

	/**
	 * @inheritDoc
	 */
	protected function clean($value) {
		if ($value === null || is_object($value)) {
			return $value;
		}
		if (is_string($value)) {
			if (substr($value, 0, 1) == '{') {
				return json_decode($value, false);
			} elseif (substr($value, 0, 2) == 'O:') {
				return unserialize($value);
			} elseif (class_exists($value, true)) {
				return new $value();
			} else {
				return null;
			}
		}
		return (object) $value;
	}
}