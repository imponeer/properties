<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\Types\DateTimeType;
use JetBrains\PhpStorm\Deprecated;

#[Deprecated(replacement: DateTimeType::class)]
class TimeOnlyType extends DateTimeType
{
    public string $format = 's:i';
}
