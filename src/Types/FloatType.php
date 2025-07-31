<?php

declare(strict_types=1);

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;

/**
 * Defines float type
 *
 * @package Imponeer\Properties\Types
 */
class FloatType extends AbstractType
{
    /**
     * Format output
     *
     * @var string
     */
    public string $format = '%d';

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
        return sprintf($this->format, $this->value);
    }

    /**
     * @inheritDoc
     */
    public function getForEdit(): string
    {
        return str_replace(['&amp;', '&nbsp;'], ['&', '&amp;nbsp;'], @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));
    }

    /**
     * @inheritDoc
     */
    public function getForForm(): string
    {
        return str_replace(['&amp;', '&nbsp;'], ['&', '&amp;nbsp;'], @htmlspecialchars($this->value, ENT_QUOTES, _CHARSET));
    }

    /**
     * @inheritDoc
     */
    protected function clean(mixed $value): float
    {
        if (is_object($value)) {
            return 0.00;
        }
        return (float) $value;
    }
}
