<?php

declare(strict_types=1);

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;

/**
 * Defines list type
 *
 * @package Imponeer\Properties\Types
 */
class ListType extends AbstractType
{
    /**
     * Separator
     *
     * @var string
     */
    public string $separator = ';';

    /**
     * @inheritDoc
     */
    public function isDefined(): bool
    {
        return !empty($this->value);
    }

    /**
     * @inheritDoc
     */
    public function getForDisplay(): string
    {
        return $this->value;
    }

    /**
     * @inheritDoc
     */
    public function getForEdit(): string
    {
        return $this->get();
    }

    /**
     * @inheritDoc
     */
    public function getForForm(): string
    {
        return \Imponeer\Properties\Helper\HtmlSanitizerHelper::prepareForHtml($this->value);
    }

    /**
     * @inheritDoc
     */
    protected function clean(mixed $value): array
    {
        if ((array) ($value) === $value) {
            return $value;
        }
        if (empty($value)) {
            return [];
        }
        if (is_string($value)) {
            return explode($this->separator, strval($value));
        } else {
            return [$value];
        }
    }
}
