<?php

declare(strict_types=1);

namespace Imponeer\Properties\Internal;

use Imponeer\Properties\Contracts\TextDisplayFilterInterface;

/**
 * Default implementation of text display filter
 *
 * Provides basic text filtering with HTML escaping and line break conversion.
 * Users can configure their own implementation (e.g., ImpressCMS sanitizer)
 * by registering it with the ServiceLocator.
 *
 * @internal
 */
final class DefaultTextDisplayFilter implements TextDisplayFilterInterface
{
    public function __invoke(
        string $text,
        int $html = 0,
        int $smiley = 1,
        int $xcode = 1,
        int $image = 1,
        int $br = 1
    ): string {
        if ($html === 0) {
            // No HTML allowed - escape it
            $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');

            // Convert line breaks if enabled
            if ($br) {
                $text = nl2br($text);
            }
        }

        // For HTML mode, return as-is (users should provide their own implementation
        // if they need XCode, smiley, or image conversion)

        return $text;
    }
}
