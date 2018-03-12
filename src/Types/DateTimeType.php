<?php
/**
 * Created by IntelliJ IDEA.
 * User: mekdr
 * Date: 1/22/2017
 * Time: 1:42 AM
 */

namespace IPFLibraries\Properties\Types;


use IPFLibraries\Properties\AbstractType;

class DateTimeType extends AbstractType {

	/**
	 * Format for output
	 *
	 * @var string
	 */
	public $format = 'r';

	/**
	 * @inheritDoc
	 */
	public function isDefined()
	{
		return is_int($this->value) && ($this->value > 0);
	}

	/**
	 * @inheritDoc
	 */
	public function getForDisplay()
	{
		return date(isset($this->format)?$this->format:'r', $this->value);
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
		if (is_int($value)) {
			return $value;
		}
		if ($value === null) {
			return 0;
		}
		if (is_numeric($value)) {
			return intval($value);
		}
		if (!is_string($value)) {
			return 0;
		}
		if (preg_match('/(\d\d\d\d)-(\d\d)-(\d\d) (\d\d):(\d\d):(\d\d)/ui', $value, $ret)) {
			$time = gmmktime($ret[4], $ret[5], $ret[6], $ret[2], $ret[3], $ret[1]);
		} else {
			$time = (int) strtotime($value);
		}
		return ($time < 0)?0:$time;
	}
}