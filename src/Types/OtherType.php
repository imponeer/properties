<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 7:32 PM
 */

namespace IPFLibraries\Properties\Types;


use IPFLibraries\Properties\AbstractType;

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