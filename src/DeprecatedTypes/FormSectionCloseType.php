<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\Types\OtherType;
use JetBrains\PhpStorm\Deprecated;

#[Deprecated(replacement: OtherType::class)]
class FormSectionCloseType extends OtherType
{
}
