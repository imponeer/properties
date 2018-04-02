<?php

namespace Imponeer\Properties\Types;


use Imponeer\Properties\AbstractType;

class OtherType extends AbstractType {

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
		return (string) $this->value;
	}

	/**
	 * @inheritDoc
	 */
	public function getForEdit() {
		return (string) $this->value;
	}

	/**
	 * @inheritDoc
	 */
	public function getForForm() {
		return (string) $this->value;
	}

	/**
	 * @inheritDoc
	 */
	protected function clean($value) {
		return $value;
	}
}