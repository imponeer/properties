<?php

declare(strict_types=1);

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;

class BooleanType extends AbstractType {

	public function isDefined(): bool {
		return true;
	}

	public function getForDisplay(): string {
		return $this->value?_YES:_NO;
	}

	public function getForEdit(): string {
		return str_replace(['&amp;', '&nbsp;'], ['&', '&amp;nbsp;'], @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));

	}

	public function getForForm(): string {
		return str_replace(['&amp;', '&nbsp;'], ['&', '&amp;nbsp;'], @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));
	}

	protected function clean(mixed $value): bool {
		if (is_bool($value)) {
			return $value;
		}
		if (!is_string($value)) {
			if (is_object($value)) {
				return true;
			} elseif (is_null($value)) {
				return false;
			}
			return (bool) intval($value);
		}
		$value = strtolower($value);
		return ($value == 'yes') || ($value == 'true');
	}
}