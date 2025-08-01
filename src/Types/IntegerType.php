<?php

declare(strict_types=1);

namespace Imponeer\Properties\Types;

use Imponeer\Properties\AbstractType;

class IntegerType extends AbstractType
{
    public function isDefined(): bool
    {
        return true;
    }

    public function getForDisplay(): string
    {
        return (string) $this->value;
    }

    public function getForEdit(): string
    {
        return \Imponeer\Properties\Helper\HtmlSanitizerHelper::prepareForHtml($this->value);
    }

    public function getForForm(): string
    {
        return \Imponeer\Properties\Helper\HtmlSanitizerHelper::prepareForHtml($this->value);
    }

    protected function clean(mixed $value): int
    {
        if (is_object($value)) {
            return 0;
        }
        return (int) $value;
    }
}
