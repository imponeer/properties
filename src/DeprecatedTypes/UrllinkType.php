<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\Enum\ValidationRule;
use Imponeer\Properties\Types\IntegerType;
use JetBrains\PhpStorm\Deprecated;

#[Deprecated(replacement: IntegerType::class)]
class UrllinkType extends IntegerType
{
    public bool $autoFormatingDisabled = true;
    public string $validateRule = ValidationRule::LINKS->value;
    public ?string $data_handler = 'link';
}
