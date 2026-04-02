<?php

declare(strict_types=1);

/**
 * Legacy ImpressCMS stubs for static analysis.
 */
class icms_core_Textsanitizer
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function displayTarea(
        string $text,
        int $html,
        int $smiley,
        int $xcode,
        int $image,
        int $br
    ): string {
        return $text;
    }
}
