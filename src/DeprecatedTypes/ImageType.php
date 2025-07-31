<?php

declare(strict_types=1);

namespace Imponeer\Properties\DeprecatedTypes;

use Imponeer\Properties\Types\IntegerType;
use JetBrains\PhpStorm\Deprecated;

#[Deprecated(replacement: IntegerType::class)]
class ImageType extends IntegerType
{
    public ?string $data_handler = 'image';
    public bool $autoFormatingDisabled = true;
    /** @var string[] */
    public array $allowedMimeTypes = [
        'image/gif',
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/svg+xml',
        'image/tiff',
        'image/vnd.microsoft.icon',
    ];
}
