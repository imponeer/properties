<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/21/2017
 * Time: 11:30 PM
 */

namespace IPFLibraries\Properties\Exceptions;


class ValidationRuleNotPassedException extends \Exception {
	/**
	 * Value
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * ValidationRuleNotPassedException constructor.
	 *
	 * @param mixed $value Bad value
	 * @param int|null $code Int
	 * @param Exception|null $previous Previous value
	 */
	public function __construct($value, $code = null, Exception $previous = null) {
		$this->value = $value;
		parent::__construct('Validation rule not passed', $code, $previous);
	}

	/**
	 * Get linked value
	 *
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

}