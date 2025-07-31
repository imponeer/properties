<?php

declare(strict_types=1);

namespace Imponeer\Properties;

/**
 * Interface for defining common vars
 *
 * @package Imponeer\Properties
 */
interface CommonPropertyInterface
{
    /**
     * Parse value
     *
     * @param mixed $default    Default value
     *
     * @return mixed
     */
    public function parseValue(mixed $default): mixed;

    /**
     * Gets datatype
     *
     * @return string|int
     */
    public function getDataType(): string|int;

    /**
     * Is required?
     *
     * @return bool
     */
    public function isRequired(): bool;

    /**
     * Gets other config data
     *
     * @return array|null
     */
    public function getOtherConfig(): ?array;

    /**
     * Gets form control options
     *
     * @return array|null
     */
    public function getControl(): ?array;
}
