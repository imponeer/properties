<?php

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;
use Imponeer\Properties\Exceptions\ValidationRuleNotPassedException;

class StringType extends AbstractType {

	/**
	 * Not GPC
	 *
	 * @var bool
	 */
	public $not_gpc = false;

	/**
	 * Validation rule
	 *
	 * @var string
	 */
	public $validateRule = '';

	/**
	 * Source formating
	 *
	 * @var string|null
	 */
	public $sourceFormating = null;

	/**
	 * Max length
	 *
	 * @var null|int
	 */
	public $maxLength = null;

	/**
	 * Automatic formatting disabled
	 *
	 * @var bool
	 */
	public $autoFormatingDisabled = false;

	/**
	 * @inheritDoc
	 */
	public function isDefined() {
		return strlen($this->value) > 0;
	}

	/**
	 * @inheritDoc
	 */
	public function getForDisplay() {
		if ($this->autoFormatingDisabled) {
			$ret = str_replace(array("&amp;", "&nbsp;"), array('&', '&amp;nbsp;'), @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));
			if (method_exists($this->parent, 'formatForML')) {
				return $this->formatForML($ret);
			}
			return $ret;
		}
		$html = (isset($this->parent->html) && $this->parent->html)?1:0;
		if (!$html) {
			return $this->value;
		}
		$xcode = (!isset($this->parent->doxcode) || $this->parent->doxcode)?1:0;
		$smiley = (!isset($this->parent->dosmiley) || $this->parent->dosmiley)?1:0;
		$image = (!isset($this->parent->doimage) || $this->parent->doimage)?1:0;
		$br = (!isset($this->parent->dobr) || $this->parent->dobr)?1:0;

		$ts = icms_core_Textsanitizer::getInstance();
		return $ts->displayTarea($this->value, $html, $smiley, $xcode, $image, $br);
	}

	/**
	 * @inheritDoc
	 */
	public function getForEdit() {
		return str_replace(["&amp;", "&nbsp;"], ['&', '&amp;nbsp;'], @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));
	}

	/**
	 * @inheritDoc
	 */
	public function getForForm() {
		return str_replace(["&amp;", "&nbsp;"], ['&', '&amp;nbsp;'], @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));
	}

	/**
	 * @inheritDoc
	 */
	protected function clean($value) {
		if (!is_string($value)) {
			if (is_array($value)) {
				$value = json_encode($value, JSON_PRETTY_PRINT);
			} elseif ($value instanceof \stdClass) {
				$value = json_encode((array) $value, JSON_PRETTY_PRINT);
			} else {
				$value = strval($value);
			}
		}
		if (!$this->not_gpc && get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		if (!empty($this->value) && !empty($this->validateRule)) {
			if (!preg_match($this->validateRule, $value)) {
				throw new ValidationRuleNotPassedException($value);
			} elseif (empty($this->sourceFormating)) {
				$value = icms_core_DataFilter::censorString($value);
			}
		}
		if (($this->maxLength > 0) && (mb_strlen($value) > $this->maxLength)) {
			trigger_error('Value was shortered', E_USER_WARNING);
			$value = mb_substr($value, 0, $this->maxLength);
		}
		return $value;
	}
}
