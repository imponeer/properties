<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\Types\IntegerType;
use JetBrains\PhpStorm\Deprecated;

#[Deprecated(replacement: IntegerType::class)]
class FileType extends IntegerType
{
    public ?string $data_handler = 'file';
    public bool $autoFormatingDisabled = true;
}
