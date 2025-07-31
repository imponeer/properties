<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\Types\StringType;
use JetBrains\PhpStorm\Deprecated;

#[Deprecated(replacement: StringType::class)]
class SourceType extends StringType
{
    public ?string $sourceFormating = 'php';
    public bool $autoFormatingDisabled = true;
}
