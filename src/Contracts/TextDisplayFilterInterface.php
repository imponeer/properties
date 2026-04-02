<?php

declare(strict_types=1);

namespace Imponeer\Properties\Contracts;

/**
 * Interface for filtering and displaying text content
 */
interface TextDisplayFilterInterface
{
    /**
     * Filter and display text with various formatting options
     *
     * @param string $text The text to filter and display
     * @param int $html Whether to allow HTML (0 = no HTML, 1 = allow HTML)
     * @param int $smiley Whether to convert smileys (0 = no, 1 = yes)
     * @param int $xcode Whether to convert xcode (0 = no, 1 = yes)
     * @param int $image Whether to convert images (0 = no, 1 = yes)
     * @param int $br Whether to convert line breaks (0 = no, 1 = yes)
     * @return string The filtered text
     */
    public function __invoke(
        string $text,
        int $html = 0,
        int $smiley = 1,
        int $xcode = 1,
        int $image = 1,
        int $br = 1
    ): string;
}
