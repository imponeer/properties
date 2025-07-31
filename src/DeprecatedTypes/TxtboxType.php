<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\Types\StringType;
use JetBrains\PhpStorm\Deprecated;

#[Deprecated(replacement: StringType::class)]
class TxtboxType extends StringType
{
    public ?int $maxLength = 255;
    public bool $autoFormatingDisabled = true;
}
