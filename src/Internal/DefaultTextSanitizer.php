<?php

declare(strict_types=1);

namespace Imponeer\Properties\Internal;

use Imponeer\Properties\Contracts\TextSanitizerInterface;

/**
 * Default implementation of text sanitizer that returns text as-is
 *
 * This is a simple pass-through implementation that doesn't perform any
 * sanitization or formatting. Users can configure their own implementation
 * by registering it with the ServiceLocator.
 *
 * @internal
 */
final class DefaultTextSanitizer implements TextSanitizerInterface
{
    public function displayTarea(
        string $text,
        int $html = 0,
        int $smiley = 1,
        int $xcode = 1,
        int $image = 1,
        int $br = 1
    ): string {
        return $text;
    }
}
