<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\Types\IntegerType;

/**
 * @deprecated
 */
class FileType extends IntegerType
{
    public string $data_handler = 'file';
    public bool $autoFormatingDisabled = true;
}
