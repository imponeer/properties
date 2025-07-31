<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;


use Imponeer\Properties\Types\FloatType;

/**
 * @deprecated
 */
class CurrencyType extends FloatType
{
    public string $format = '%d';
}