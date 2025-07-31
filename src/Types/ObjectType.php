<?php

declare(strict_types=1);

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
	public function isDefined(): bool {
		return is_object($this->value);
	}

	/**
	 * @inheritDoc
	 */
	public function getForDisplay(): string {
		return (string) $this->value;
	}

	/**
	 * @inheritDoc
	 */
	public function getForEdit(): null|string {
		return null;
	}

	/**
	 * @inheritDoc
	 */
	public function getForForm(): null|string {
		return null;
	}

	/**
	 * @inheritDoc
	 */
	protected function clean(mixed $value): object|null {
		if ($value === null || is_object($value)) {
			return $value;
		}
		if (is_string($value)) {
			return $this->unserializeValue($value);
		}
		return (object) $value;
	}

	/**
	 * Unserialize value from string when cleaning it
	 *
	 * @param string $value Value to unserialize
	 *
	 * @return null|object
	 */
	protected function unserializeValue(string $value): object|null {
		if ($value[0] == '{' || $value[0] == '[') {
			return (object)json_decode($value, false);
		} elseif (in_array(substr($value, 0, 2), ['O:', 'a:'])) {
			return (object)unserialize($value);
		} elseif (class_exists($value, true)) {
			return new $value();
		} else {
			return null;
		}
	}
}