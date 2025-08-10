<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\Enum\ValidationRule;
use Imponeer\Properties\Types\StringType;
use JetBrains\PhpStorm\Deprecated;

#[Deprecated(replacement: StringType::class)]
class EmailType extends StringType
{
    public bool $autoFormatingDisabled = true;
    public string $validateRule = ValidationRule::EMAIL->value;
}
