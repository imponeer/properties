<?php

declare(strict_types=1);

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;

/**
 * Define 'other' type
 *
 * @package Imponeer\Properties\Types
 */
class OtherType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function isDefined(): bool
    {
        return true;
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
        return (string) $this->value;
    }

    /**
     * @inheritDoc
     */
    public function getForForm(): string
    {
        return (string) $this->value;
    }

    /**
     * @inheritDoc
     */
    protected function clean(mixed $value): mixed
    {
        return $value;
    }
}
