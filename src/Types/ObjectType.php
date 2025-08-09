<?php

declare(strict_types=1);

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;
use JsonException;

/**
 * Defines object type
 *
 * @package Imponeer\Properties\Types
 */
class ObjectType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function isDefined(): bool
    {
        return is_object($this->value);
    }

    /**
     * @inheritDoc
     */
    public function getForDisplay(): string
    {
        return (string) $this->value;
    }

    /**
     * @inheritDoc
     */
    public function getForEdit(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     */
    public function getForForm(): string
    {
        return '';
    }

    /**
     * @inheritDoc
     *
     * @throws JsonException
     */
    protected function clean(mixed $value): object|null
    {
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
     *
     * @throws JsonException
     */
    protected function unserializeValue(string $value): object|null
    {
        if ($value[0] === '{' || $value[0] === '[') {
            return (object)json_decode($value, false, 512, JSON_THROW_ON_ERROR);
        }

        if (in_array(substr($value, 0, 2), ['O:', 'a:'])) {
            return (object)unserialize($value);
        }

        if (class_exists($value, true)) {
            return new $value();
        }

        return null;
    }
}
