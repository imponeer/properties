<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\Types\FloatType;
use JetBrains\PhpStorm\Deprecated;

#[Deprecated(replacement: FloatType::class)]
class CurrencyType extends FloatType
{
    public string $format = '%d';
}
