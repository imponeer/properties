<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\Types\DateTimeType;
use JetBrains\PhpStorm\Deprecated;

#[Deprecated(replacement: DateTimeType::class)]
class MtimeType extends DateTimeType
{
    public string $format = _MEDIUMDATESTRING;
}
