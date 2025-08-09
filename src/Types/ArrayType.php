<?php

declare(strict_types=1);

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;
use Imponeer\Properties\Helper\HtmlSanitizerHelper;
use JsonException;

/**
 * Defines array type
 *
 * @package Imponeer\Properties\Types
 */
class ArrayType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function isDefined(): bool
    {
        return !empty($this->value);
    }

    /**
     * @inheritDoc
     *
     * @throws JsonException
     */
    public function getForDisplay(): string
    {
        return json_encode($this->value, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT);
    }

    /**
     * @inheritDoc
     */
    public function getForEdit(): string
    {
        return HtmlSanitizerHelper::prepareForHtml($this->value);
    }

    /**
     * @inheritDoc
     */
    public function getForForm(): string
    {
        return HtmlSanitizerHelper::prepareForHtml($this->value);
    }

	/**
	 * @inheritDoc
	 *
	 * @throws JsonException
	 */
    protected function clean(mixed $value): array
    {
        if (((array) $value) === $value) {
            return $value;
        }
        if (empty($value) && !is_numeric($value)) {
            return [];
        }
        if (is_string($value)) {
            return $this->unserializeValue($value);
        }
        return (array) $value;
    }

    /**
     * Unserialize value from string when cleaning it
     *
     * @param string $value Value to unserialize
     *
     * @return null|array
     *
     * @throws JsonException
     */
    protected function unserializeValue(string $value): array|null
    {
        if ($value[0] === '{' || $value[0] === '[') {
            return (array)json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        }

        if (in_array(substr($value, 0, 2), ['O:', 'a:'])) {
            return (array)unserialize($value);
        }

        if (is_numeric($value)) {
            return (array)$value;
        }

        return [];
    }
}
