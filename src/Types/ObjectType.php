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
        if ($value === null) {
            return new \stdClass();
        }
        if (is_object($value)) {
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
        if ($value === '') {
            return null;
        }

        if ($value[0] === '{' || $value[0] === '[') {
            $decoded = json_decode($value, false, 512, JSON_THROW_ON_ERROR);
            return is_object($decoded) ? $decoded : ((is_array($decoded)) ? (object)$decoded : null);
        }

        if (in_array(substr($value, 0, 2), ['O:', 'a:'])) {
            $unserialized = unserialize($value);
            return (is_object($unserialized) || is_array($unserialized)) ? (object)$unserialized : null;
        }

        if (class_exists($value, true)) {
            return new $value();
        }

        $unserialized = @unserialize($value);
        if ($unserialized !== false || $value === 'b:0;' || $value === 'N;') {
            return (is_object($unserialized) || is_array($unserialized)) ? (object)$unserialized : null;
        }

        return null;
    }
}
